<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Admin/User/UserIndex', [
            "users" => UserResource::collection(User::all()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/User/CreateUser', [
            "roles" => RoleResource::collection(Role::all()),
            'permissions' => PermissionResource::collection(Permission::all())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'roles' => ["sometimes", "array"],
            'permissions' => ["sometimes", "array"],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        if ($request->has('roles')) {
            $user->syncRoles($request->input('roles.*.name'));
        }
        if ($request->has('permissions')) {
            $user->syncPermissions($request->input('permissions.*.name'));
        }
        return to_route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        $user->load(['roles', 'permissions']);
        return Inertia::render('Admin/User/EditUser', [
            "user" => new UserResource($user),
            "roles" => RoleResource::collection(Role::all()),
            'permissions' => PermissionResource::collection(Permission::all())
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'roles' => ["sometimes", "array"],
            'permissions' => ["sometimes", "array"]
        ]);
        $user = User::find($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        if ($request->has('roles')) {
            $user->syncRoles($request->input('roles.*.name'));
        }
        if ($request->has('permissions')) {
            $user->syncPermissions($request->input('permissions.*.name'));
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return to_route('users.index');
    }
}
