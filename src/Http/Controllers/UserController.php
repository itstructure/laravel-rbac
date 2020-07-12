<?php

namespace Itstructure\LaRbac\Http\Controllers;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Itstructure\LaRbac\Helpers\Helper;
use Itstructure\LaRbac\Models\Role;
use Itstructure\LaRbac\Http\Requests\{
    UpdateUser as UpdateUserRequest,
    Delete as DeleteUserRequest
};
use Itstructure\GridView\DataProviders\EloquentDataProvider;
use App\Http\Controllers\Controller;

/**
 * Class UserController
 *
 * @package Itstructure\LaRbac\Http\Controllers
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class UserController extends Controller
{
    /**
     * @var string
     */
    private $_userModelClass;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->_userModelClass = config('rbac.userModelClass');
    }

    /**
     * Get list of all users.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        /** @var Authenticatable $userModelObj */
        $userModelObj = new $this->_userModelClass();

        $dataProvider = new EloquentDataProvider($userModelObj->newQuery()->with('roles'));

        $authIdentifierName = $userModelObj->getAuthIdentifierName();

        return view('rbac::users.index', compact('dataProvider', 'authIdentifierName'));
    }

    /**
     * Render page to edit current user.
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id)
    {
        $user = $this->findOrFail($id);

        $allRoles = Role::orderBy('id', 'desc')->get();
        $currentRoles = old('roles') ?? $user->roles->pluck('id')->toArray();

        return view('rbac::users.edit', compact('user', 'allRoles', 'currentRoles'));
    }

    /**
     * Update current user data.
     * @param int $id
     * @param UpdateUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(int $id, UpdateUserRequest $request)
    {
        $this->findOrFail($id)
            ->fill($request->all())
            ->save();

        return redirect()->route('show_user', compact('id'));
    }

    /**
     * Render page to show current user.
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(int $id)
    {
        $user = $this->findOrFail($id);

        return view('rbac::users.show', compact('user'));
    }

    /**
     * Delete current user data.
     * @param DeleteUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(DeleteUserRequest $request)
    {
        foreach ($request->items as $item) {

            if (!is_numeric($item) || $request->user()->getAuthIdentifier() == $item) {
                continue;
            }

            call_user_func([
                $this->_userModelClass,
                'destroy',
            ], $item);
        }

        return redirect()->route('list_users');
    }

    /**
     * Find or fail user data.
     * @param int $id
     * @return mixed
     */
    private function findOrFail(int $id)
    {
        return Helper::retrieveUserModel($this->_userModelClass, $id);
    }
}
