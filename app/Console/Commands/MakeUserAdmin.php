<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class MakeUserAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:make-admin {email : L\'adresse email de l\'utilisateur}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assigne le rôle administrateur à un utilisateur existant';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("Aucun utilisateur trouvé avec l'email: {$email}");
            return 1;
        }

        // Vérifier si le rôle admin existe, sinon le créer
        $adminRole = Role::where('name', 'admin')->first();
        if (!$adminRole) {
            $this->info("Le rôle 'admin' n'existe pas, création en cours...");
            $adminRole = Role::create(['name' => 'admin']);
        }

        // Assigner le rôle admin à l'utilisateur
        $user->assignRole('admin');
        
        $this->info("L'utilisateur {$user->name} ({$user->email}) est maintenant administrateur.");
        
        return 0;
    }
}
