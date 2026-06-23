<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\User;
use App\Modules\Users\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Affiche la liste des utilisateurs
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Affiche le formulaire de création d'utilisateur
     */
    public function create()
    {
        $roles = UserRole::cases();
        $agencies = Agency::active()->get();
        
        return view('admin.users.create', compact('roles', 'agencies'));
    }

    /**
     * Enregistre un nouvel utilisateur
     */
    public function store(Request $request)
    {
        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:admin,caissier,superviseur,comptable'],
        ];

        // Règle conditionnelle pour agency_id si le rôle est caissier
        if ($request->role === 'caissier') {
            $rules['agency_id'] = ['required', 'exists:agencies,id'];
        }

        $request->validate($rules);

        $userData = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => UserRole::from($request->role),
        ];

        // Ajouter agency_id si le rôle est caissier
        if ($request->role === 'caissier') {
            $userData['agency_id'] = $request->agency_id;
        }

        User::create($userData);

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Affiche les détails d'un utilisateur
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Affiche le formulaire d'édition d'utilisateur
     */
    public function edit(User $user)
    {
        $roles = UserRole::cases();
        $agencies = Agency::active()->get();
        
        return view('admin.users.edit', compact('user', 'roles', 'agencies'));
    }

    /**
     * Met à jour un utilisateur
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'string', 'in:admin,caissier,superviseur,comptable'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ];

        // Règle conditionnelle pour agency_id si le rôle est caissier
        if ($request->role === 'caissier') {
            $rules['agency_id'] = ['required', 'exists:agencies,id'];
        }

        $request->validate($rules);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->role = UserRole::from($request->role);
        
        // Mettre à jour agency_id si le rôle est caissier
        if ($request->role === 'caissier') {
            $user->agency_id = $request->agency_id;
        } else {
            $user->agency_id = null;
        }
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Supprime un utilisateur
     */
    public function destroy(User $user)
    {
        // Empêcher la suppression de soi-même
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }
}
