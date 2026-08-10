<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PlatformSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::firstOrCreate(
            ['slug' => 'recrivo-platform'],
            ['name' => 'Recrivo Platform', 'is_active' => true]
        );

        $role = Role::where('name', 'Super Admin')->firstOrFail();

        User::firstOrCreate(
            ['email' => 'superadmin@recrivo.test'],
            [
                'tenant_id' => $tenant->id,
                'role_id' => $role->id,
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'password' => Hash::make('password'), // change after seeding
                'email_verified_at' => now(),
            ]
        );
    }
}
