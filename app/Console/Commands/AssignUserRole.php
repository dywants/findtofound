<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class AssignUserRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:role {email} {role} {--remove : Retirer le rôle au lieu de l\'assigner}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assigne ou retire un rôle à un utilisateur';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email');
        $roleName = $this->argument('role');
        $remove = $this->option('remove');

        // Trouver l'utilisateur
        $user = User::where('email', $email)->first();
        if (!$user) {
            $this->error("Aucun utilisateur trouvé avec l'email: {$email}");
            return 1;
        }

        // Vérifier si le rôle existe
        $role = Role::where('name', $roleName)->first();
        if (!$role) {
            $this->info("Le rôle '{$roleName}' n'existe pas, voici la liste des rôles disponibles:");
            $roles = Role::all()->pluck('name');
            $this->table(['Rôles disponibles'], $roles->map(function($role) {
                return [$role];
            }));
            return 1;
        }

        // Assigner ou retirer le rôle
        try {
            if ($remove) {
                $user->removeRole($role);
                $this->info("Le rôle '{$roleName}' a été retiré de l'utilisateur {$user->name} ({$user->email}).");
            } else {
                $user->assignRole($role);
                $this->info("Le rôle '{$roleName}' a été assigné à l'utilisateur {$user->name} ({$user->email}).");
            }
            
            // Afficher les rôles actuels de l'utilisateur
            $this->info("Rôles actuels de l'utilisateur {$user->name}:");
            $this->table(['Rôles'], $user->roles->pluck('name')->map(function($role) {
                return [$role];
            }));
            
            return 0;
        } catch (\Exception $e) {
            $this->error("Une erreur est survenue: " . $e->getMessage());
            return 1;
        }
    }
}
