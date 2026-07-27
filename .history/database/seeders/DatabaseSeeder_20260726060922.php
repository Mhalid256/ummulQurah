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
            ['slug' => 'hope-foundation'],
            [
                'name' => 'Hope Foundation',
                'email' => 'info@hopefoundation.org',
                'phone' => '+256700000000',
                'country' => 'Uganda',
                'currency' => 'UGX',
                'status' => 'active',
            ]
        );

        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@charityconnect.test'],
            [
                'organization_id' => null,
                'name' => 'System Super Admin',
                'password' => Hash::make('password'),
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        $superAdmin->assignRole('Super Administrator');

        $orgAdmin = User::firstOrCreate(
            ['email' => 'admin@hopefoundation.org'],
            [
                'organization_id' => $organization->id,
                'name' => 'Hope Foundation Admin',
                'password' => Hash::make('password'),
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        $orgAdmin->assignRole('Organization Administrator');

        $financeOfficer = User::firstOrCreate(
            ['email' => 'finance@hopefoundation.org'],
            [
                'organization_id' => $organization->id,
                'name' => 'Finance Officer',
                'password' => Hash::make('password'),
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        $financeOfficer->assignRole('Finance Officer');
    }
}
