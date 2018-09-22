<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\UpdateRoleRequest;
use Grimm\Permission;
use Grimm\Role;
use Grimm\User;

class RolesController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        $permissions = Permission::orderBy('name')->get();

        return view('roles.create', compact('users', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleStoreRequest $request)
    {
        $id = $request->persist();

        return redirect()
            ->route('roles.show', ['id' => $id])
            ->with('success', trans('users.store.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /** @var Role $role */
        $role = Role::query()->with('permissions', 'users')->findOrFail($id);

        $users = User::orderBy('name')->get();
        $permissions = Permission::orderBy('name')->get();

        return view('roles.show', compact('role', 'users', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRoleRequest $request
     * @param Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->name = $request->input('name');

        $role->users()->sync($request->input('users', []));

        $role->permissions()->sync($request->input('permissions', []));

        $role->save();

        return redirect()->route('roles.show', [$role->id])->with('success', trans('users.update.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
