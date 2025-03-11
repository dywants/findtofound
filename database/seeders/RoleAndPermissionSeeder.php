<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset les permissions mémorisées
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Création des permissions
        $permissions = [
            'manage users',
            'manage finds',
            'manage faqs',
            'manage payments',
            'manage subscriptions',
            'manage currencies',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Création du rôle admin avec toutes les permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // Création du rôle utilisateur standard
        $userRole = Role::create(['name' => 'user']);
    }
}
