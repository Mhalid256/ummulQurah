<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Communication;
use App\Models\Donor;
use App\Models\User;
use App\Models\Volunteer;
use App\Services\Sms\AfricasTalkingGateway;
use App\Services\WhatsApp\WhatsAppCloudApiGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CommunicationController extends Controller
{
    public function index()
    {
        $communications = Communication::with('sentBy')->latest()->paginate(15);
        return view('admin.communications.index', compact('communications'));
    }

    public function create()
    {
        return view('admin.communications.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'channel' => 'required|in:email,sms,whatsapp,in_app',
            'audience' => 'required|in:all_donors,all_sponsors,all_volunteers,all_staff,custom',
        ]);

        $recipients = $this->resolveAudience($data['audience']);
        $data['recipients_count'] = $recipients->count();
        $data['sent_by'] = auth()->id();
        $data['sent_at'] = now();
        $data['status'] = 'queued';

        $communication = Communication::create($data);

        [$successCount, $failureCount] = $this->dispatch($data['channel'], $data['subject'], $data['body'], $recipients);

        $communication->update([
            'status' => $failureCount === 0 ? 'sent' : ($successCount === 0 ? 'failed' : 'sent'),
        ]);

        $note = $successCount > 0
            ? "Sent to {$successCount} of {$data['recipients_count']} recipient(s)."
            : 'Message could not be sent — check that the relevant provider is configured in .env (see notes on the Communication page).';

        return redirect()->route('admin.communications.index')->with('success', $note);
    }

    public function destroy(Communication $communication)
    {
        $communication->delete();
        return back()->with('success', 'Message record removed.');
    }

    /**
     * Returns a collection of ['email' => ..., 'phone' => ...] for the
     * chosen audience, since different channels need different fields.
     */
    protected function resolveAudience(string $audience)
    {
        return match ($audience) {
            'all_donors' => Donor::where('status', 'active')->get(['email', 'phone']),
            'all_sponsors' => Donor::where('is_recurring', true)->get(['email', 'phone']),
            'all_volunteers' => Volunteer::where('status', 'active')->get(['email', 'phone']),
            'all_staff' => User::get(['email', 'phone']),
            default => collect(),
        };
    }

    /**
     * Actually sends the message through the right channel. Each recipient
     * is attempted independently so one bad phone/email doesn't sink the
     * whole batch; failures are logged and counted.
     *
     * @return array{0:int,1:int} [successCount, failureCount]
     */
    protected function dispatch(string $channel, string $subject, string $body, $recipients): array
    {
        $success = 0;
        $failure = 0;

        foreach ($recipients as $recipient) {
            try {
                $sent = match ($channel) {
                    'email' => $this->sendEmail($recipient->email, $subject, $body),
                    'sms' => $recipient->phone ? (new AfricasTalkingGateway())->send($recipient->phone, $body)['sent'] : false,
                    'whatsapp' => $recipient->phone ? (new WhatsAppCloudApiGateway())->send($recipient->phone, $body)['sent'] : false,
                    'in_app' => true, // no external dispatch — would insert an in-app notification record here
                    default => false,
                };
            } catch (\Throwable $e) {
                Log::error("Communication dispatch failed via {$channel}", ['error' => $e->getMessage()]);
                $sent = false;
            }

            $sent ? $success++ : $failure++;
        }

        return [$success, $failure];
    }

    protected function sendEmail(?string $email, string $subject, string $body): bool
    {
        if (! $email) {
            return false;
        }

        Mail::raw($body, function ($message) use ($email, $subject) {
            $message->to($email)->subject($subject);
        });

        return true;
    }
}