<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query();
        $users->when($request->keyword, function ($query, $keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', '%' . $keyword . '%')->orWhere('email', 'LIKE', '%' . $keyword . '%');
            });
        });
        $users = $users->paginate();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $input = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        User::create($input);
        return redirect()->route('users.index')->with('status', 'User created successfully');
    }

    public function edit(User $user)
    {
        Gate::authorize('edit',User::class);

        $user->load(['profile', 'interests']);
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        Gate::authorize('edit',User::class);

        $input = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'exclude_if:password,null|min:8',
        ]);

        $user->update($input);
        return redirect()->route('users.index')->with('status', 'User updated successfully');
    }

    public function updateProfile(Request $request, User $user)
    {
        Gate::authorize('edit',User::class);

        $input = $request->validate([
            'type' => 'required',
            'address' => 'nullable',
        ]);
        UserProfile::updateOrCreate(
            ['user_id' => $user->id],
            $input
        );
        return redirect()->route('users.index')->with('status', 'Profile updated successfully');
    }

    public function updateInterests(Request $request, User $user)
    {
        Gate::authorize('edit',User::class);

        $input = $request->validate([
            'interests' => 'nullable|array',
        ]);
        $user->interests()->delete();
        if (!empty($input['interests'])) {
            $user->interests()->createMany($input['interests']);
        }

        return redirect()->route('users.index')->with('status', 'Interests updated successfully');
    }

    public function updateRoles(Request $request, User $user)
    {
        Gate::authorize('edit',User::class);

        $input = $request->validate([
            'roles' => 'required|array',
        ]);

        $user->roles()->sync($input['roles']);
        return redirect()->route('users.index')->with('status', 'Roles updated successfully');
    }

    public function destroy(User $user)
    {
        Gate::authorize('destroy',User::class);
        
        $user->delete();
        return redirect()->route('users.index')->with('status', 'User deleted successfully');
    }
}
