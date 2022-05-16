<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::factory()->create([
            'name' => 'BAYONG Cyrille',
            'email' => 'dywantscm@gmail.com',
            'email_verified_at' => now(),
            'password' =>  Hash::make('dywantscm'),
            'remember_token' => Str::random(10),
            'role_id' => 3
        ]);

//        $user->assignRole('admin');
    }
}
