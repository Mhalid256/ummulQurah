<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function general()
    {
        $organization = auth()->user()->organization;
        return view('admin.settings.general', compact('organization'));
    }

    public function updateGeneral(Request $request)
    {
        $organization = auth()->user()->organization;

        if (! $organization) {
            return back()->with('error', 'Only organization accounts can edit these settings.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'country' => 'nullable|string|max:100',
            'currency' => 'required|string|max:8',
        ]);

        $organization->update($data);

        return back()->with('success', 'Organization settings updated.');
    }

    public function notifications()
    {
        $organizationId = auth()->user()->organization_id;
        $channels = [
            'notify_email' => Setting::getFor($organizationId, 'notify_email', true),
            'notify_sms' => Setting::getFor($organizationId, 'notify_sms', false),
            'notify_whatsapp' => Setting::getFor($organizationId, 'notify_whatsapp', false),
        ];

        return view('admin.settings.notifications', compact('channels'));
    }

    public function updateNotifications(Request $request)
    {
        $organizationId = auth()->user()->organization_id;

        foreach (['notify_email', 'notify_sms', 'notify_whatsapp'] as $key) {
            Setting::setFor($organizationId, $key, $request->boolean($key));
        }

        return back()->with('success', 'Notification preferences updated.');
    }

    public function profile()
    {
        return view('admin.settings.profile', ['user' => auth()->user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:50',
        ]);

        $user->update($data);

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8|confirmed']);
            $user->update(['password' => bcrypt($request->password)]);
        }

        return back()->with('success', 'Profile updated successfully.');
    }
}
