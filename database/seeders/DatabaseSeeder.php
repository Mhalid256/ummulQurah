<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RolePermissionSeeder::class);

        $organization = Organization::firstOrCreate(
            ['slug' => 'ummulqurah'],
            [
                'name' => 'UmmulQurah',
                'email' => 'info@ummulqurah.com',
                'phone' => '+256701098373',
                'country' => 'Uganda',
                'currency' => 'UGX',
                'status' => 'active',
            ]
        );

        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@ummulqurah.com'],
            [
                'organization_id' => null,
                'name' => 'super admin',
                'password' => Hash::make('UmmulQurah@2024'),
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        $superAdmin->assignRole('Super Administrator');

        $orgAdmin = User::firstOrCreate(
            ['email' => 'admin@ummulqurah.com'],
            [
                'organization_id' => $organization->id,
                'name' => 'UmmulQurah Admin',
                'password' => Hash::make('UmmulQurah@2025'),
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        $orgAdmin->assignRole('Organization Administrator');

        $financeOfficer = User::firstOrCreate(
            ['email' => 'finance@ummulqurah.com'],
            [
                'organization_id' => $organization->id,
                'name' => 'Finance Officer',
                'password' => Hash::make('UmmulQurah@2026'),
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        $financeOfficer->assignRole('Finance Officer');
    }
}
