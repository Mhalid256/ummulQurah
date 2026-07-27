<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationSwitchController extends Controller
{
    /**
     * Only Super Administrators reach this — they have no organization_id
     * of their own, so this session value stands in for it wherever the
     * app needs "which organization am I working in right now".
     */
    public function switch(Request $request)
    {
        $request->validate([
            'organization_id' => 'nullable|exists:organizations,id',
        ]);

        if ($request->filled('organization_id')) {
            session(['acting_organization_id' => (int) $request->organization_id]);
        } else {
            $request->session()->forget('acting_organization_id');
        }

        return back()->with('success', 'Switched organization context.');
    }
}