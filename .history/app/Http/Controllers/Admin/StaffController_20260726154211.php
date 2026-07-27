<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class StaffController extends Controller
{
    public function index()
    {
        $staff = User::with('roles')
            ->when(! auth()->user()->isSuperAdmin(), fn ($q) => $q->where('organization_id', auth()->user()->organization_id))
            ->latest()
            ->paginate(15);

        return view('admin.staff.index', compact('staff'));
    }

    public function create()
    {
        return view('admin.staff.form', ['staffMember' => new User(), 'roles' => Role::orderBy('name')->get()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, true);
        $data['organization_id'] = auth()->user()->isSuperAdmin()
            ? $request->input('organization_id')
            : auth()->user()->organization_id;
        $data['password'] = Hash::make($data['password']);
        $data['email_verified_at'] = now();

        $user = User::create($data);
        $user->syncRoles($request->input('roles', []));

        return redirect()->route('admin.staff.index')->with('success', 'Staff member created successfully.');
    }

    public function edit(User $staffMember)
    {
        return view('admin.staff.form', [
            'staffMember' => $staffMember,
            'roles' => Role::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, User $staffMember)
    {
        $data = $this->validated($request, false);

        // 'password' is nullable in validation, so an empty field still comes
        // through as $data['password'] = null. Strip it out first, then only
        // set it if the admin actually typed a new one — otherwise this would
        // overwrite the existing (NOT NULL) password column with null.
        unset($data['password']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $staffMember->update($data);
        $staffMember->syncRoles($request->input('roles', []));

        return redirect()->route('admin.staff.index')->with('success', 'Staff member updated successfully.');
    }

    public function destroy(User $staffMember)
    {
        $staffMember->delete();
        return back()->with('success', 'Staff member removed.');
    }

    protected function validated(Request $request, bool $isNew): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email' . ($isNew ? '' : ',' . $request->route('staffMember')?->id),
            'phone' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive,suspended',
            'roles' => 'array',
        ];

        if ($isNew) {
            $rules['password'] = 'required|string|min:8';
        } else {
            $rules['password'] = 'nullable|string|min:8';
        }

        return $request->validate($rules);
    }
}