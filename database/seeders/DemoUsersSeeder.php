<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Support\Facades\Hash;

class DemoUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'contratista' => 'contratista@demo.com',
            'contratacion' => 'contratacion@demo.com',
            'sinrol' => 'sinrol@demo.com',
        ];
        foreach ($roles as $roleName => $email) {
            $role = Roles::where('name', $roleName)->first();
            if ($role) {
                User::updateOrCreate(
                    ['email' => $email],
                    [
                        'name' => ucfirst($roleName) . ' Demo',
                        'email' => $email,
                        'password' => Hash::make('demo1234'),
                        'role_id' => $role->id,
                    ]
                );
            }
        }
    }
}
