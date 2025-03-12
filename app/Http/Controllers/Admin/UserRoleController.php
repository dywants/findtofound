<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    /**
     * Affiche la liste des utilisateurs avec leurs rôles
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        // Récupérer tous les utilisateurs avec leurs rôles
        $users = User::with('roles')->get();
        $roles = Role::all();

        return Inertia::render('Admin/UserRoles', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    /**
     * Met à jour les rôles d'un utilisateur
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateRoles(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        // Commencer une transaction pour assurer l'intégrité des données
        DB::beginTransaction();
        try {
            // Supprimer tous les rôles actuels de l'utilisateur
            $user->roles()->detach();
            
            // Attribuer les nouveaux rôles
            foreach ($request->roles as $roleId) {
                $role = Role::findById($roleId);
                $user->assignRole($role);
            }
            
            DB::commit();
            return redirect()->back()->with('success', 'Les rôles de l\'utilisateur ont été mis à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la mise à jour des rôles: ' . $e->getMessage());
        }
    }

    /**
     * Attribue le rôle d'administrateur à un utilisateur
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function makeAdmin(User $user)
    {
        // Vérifier si le rôle admin existe
        $adminRole = Role::where('name', 'Admin')->first();
        
        if (!$adminRole) {
            return redirect()->back()->with('error', 'Le rôle d\'administrateur n\'existe pas.');
        }

        try {
            $user->assignRole($adminRole);
            return redirect()->back()->with('success', 'L\'utilisateur ' . $user->name . ' est maintenant administrateur.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }

    /**
     * Retire le rôle d'administrateur à un utilisateur
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeAdmin(User $user)
    {
        try {
            $user->removeRole('Admin');
            return redirect()->back()->with('success', 'Le rôle d\'administrateur a été retiré de ' . $user->name . '.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }
}
