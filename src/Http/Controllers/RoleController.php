<?php

namespace Itstructure\LaRbac\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Itstructure\LaRbac\Models\{Role, Permission};
use Itstructure\LaRbac\Http\Requests\{
    StoreRole as StoreRoleRequest,
    UpdateRole as UpdateRoleRequest,
    Delete as DeleteRoleRequest
};
use App\Http\Controllers\Controller;

/**
 * Class RoleController
 *
 * @package Itstructure\LaRbac\Http\Controllers
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class RoleController extends Controller
{
    /**
     * Get list of all roles.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $roles = Role::with('permissions')->orderBy('id', 'asc')
            ->paginate(Config::get('rbac.paginate.main'));

        return view('rbac::roles.index', compact('roles'));
    }

    /**
     * Render page to create new role.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $allPermissions = Permission::orderBy('id', 'desc')->pluck('name', 'id');

        return view('rbac::roles.create', compact('allPermissions'));
    }

    /**
     * Store new role data.
     *
     * @param StoreRoleRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRoleRequest $request)
    {
        Role::create($request->all());

        return redirect()->route('list_roles');
    }

    /**
     * Render page to edit current role.
     *
     * @param Role $role
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Role $role)
    {
        $allPermissions = Permission::orderBy('id', 'desc')->pluck('name', 'id');
        $currentPermissions = old('permissions') ?? $role->permissions()->pluck('id')->toArray();

        return view('rbac::roles.edit', compact('role', 'allPermissions', 'currentPermissions'));
    }

    /**
     * Update current role data.
     *
     * @param Role $role
     * @param UpdateRoleRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Role $role, UpdateRoleRequest $request)
    {
        $role->fill($request->all())->save();

        return redirect()->route('show_role', [
            'id' => $role->id
        ]);
    }

    /**
     * Render page to show current role.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(int $id)
    {
        $role = Role::findOrFail($id);

        return view('rbac::roles.show', compact('role'));
    }

    /**
     * Delete current role data.
     *
     * @param DeleteRoleRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(DeleteRoleRequest $request)
    {
        foreach ($request->items as $item) {

            if (!is_numeric($item)) {
                continue;
            }

            Role::destroy($item);
        }

        return redirect()->route('list_roles');
    }
}
