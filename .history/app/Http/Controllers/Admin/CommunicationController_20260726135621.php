<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Communication;
use App\Models\Donor;
use App\Models\Volunteer;
use App\Models\User;
use Illuminate\Http\Request;

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

    /**
     * NOTE: This does not yet dispatch real email/SMS/WhatsApp messages.
     * Per the current build phase, sending is intentionally stubbed —
     * the message is logged and the recipient count is computed so the
     * UI/workflow is fully wired up. To go live, plug a driver into
     * sendToAudience() below (Mail::to()->send(...), an SMS gateway
     * client, or the WhatsApp Business API) behind the same interface.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'channel' => 'required|in:email,sms,whatsapp,in_app',
            'audience' => 'required|in:all_donors,all_sponsors,all_volunteers,all_staff,custom',
        ]);

        $data['recipients_count'] = $this->countAudience($data['audience']);
        $data['sent_by'] = auth()->id();
        $data['sent_at'] = now();
        $data['status'] = 'sent'; // would be 'queued' -> 'sent'/'failed' with a real driver

        Communication::create($data);

        return redirect()->route('admin.communications.index')
            ->with('success', "Message queued for {$data['recipients_count']} recipient(s). (Sending is stubbed in this build phase.)");
    }

    public function destroy(Communication $communication)
    {
        $communication->delete();
        return back()->with('success', 'Message record removed.');
    }

    protected function countAudience(string $audience): int
    {
        return match ($audience) {
            'all_donors' => Donor::where('status', 'active')->count(),
            'all_sponsors' => Donor::where('is_recurring', true)->count(),
            'all_volunteers' => Volunteer::where('status', 'active')->count(),
            'all_staff' => User::count(),
            default => 0,
        };
    }
}
