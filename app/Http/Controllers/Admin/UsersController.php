<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
   public function index()
{
    abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    $query = User::with(['roles']);

    // If not super admin → show only users created by logged-in user
    if (!auth()->user()->roles()->where('id', 3)->exists()) {
        $query->where('created_by_id', auth()->id());
    }

    $users = $query->get();

    return view('admin.users.index', compact('users'));
}


  public function create()
{
    abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    $currentUser = auth()->user();

    // SUPER ADMIN (Role ID = 1) → all roles
    if ($currentUser->roles()->where('id', 3)->exists()) {
        $roles = Role::pluck('title', 'id');

    } else {
        // ADMIN → only "User" role show
        $roles = Role::where('title', 'User')->pluck('title', 'id');
        // OR If you know role id then use:
        // $roles = Role::where('id', 2)->pluck('title', 'id');
    }

    return view('admin.users.create', compact('roles'));
}


   public function store(StoreUserRequest $request)
{
    $data = $request->all();
    $data['created_by_id'] = auth()->id();   // <-- Logged-in user ka ID add kar diya

    $user = User::create($data);

    $user->roles()->sync($request->input('roles', []));

    return redirect()->route('admin.users.index');
}


    public function edit(User $user)
{
    abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    $currentUser = auth()->user();

    // SUPER ADMIN (Role ID = 1) → all roles
    if ($currentUser->roles()->where('id', 3)->exists()) {
        $roles = Role::pluck('title', 'id');

    } else {
        // ADMIN → only "User" role
        $roles = Role::where('title', 'User')->pluck('title', 'id');
        // Or use role_id if fixed:
        // $roles = Role::where('id', 2)->pluck('title', 'id');
    }

    $user->load('roles');

    return view('admin.users.edit', compact('roles', 'user'));
}

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles');

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        $users = User::find(request('ids'));

        foreach ($users as $user) {
            $user->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
