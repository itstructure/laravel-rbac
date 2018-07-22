<?php
namespace Itstructure\LaRbac\Http\Controllers;

use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;
use Itstructure\LaRbac\Http\Requests\UpdateUser as UpdateUserRequest;
use Itstructure\LaRbac\Helpers\Helper;
use Itstructure\LaRbac\Models\Role;

/**
 * Class UserController
 *
 * @package Itstructure\LaRbac\Http\Controllers
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class UserController extends Controller
{
    /**
     * @var string
     */
    private $userModelClass;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->userModelClass = config('rbac.userModelClass');

        Helper::checkUserModel($this->userModelClass);
    }

    /**
     * Get list of all users.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = call_user_func([
            $this->userModelClass,
            'with',
        ], 'roles')->orderBy('id', 'asc')
            ->paginate(Config::get('rbac.paginate.main'));

        return view('rbac::users.index', compact('users'));
    }

    /**
     * Render page to edit current user.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id)
    {
        $user = $this->findOrFail($id);

        $allRoles = Role::orderBy('id', 'desc')->pluck('name', 'id');
        $currentRoles = old('roles') ? old('roles') : $user->roles->pluck('id')->toArray();

        return view('rbac::users.edit', compact('user', 'allRoles', 'currentRoles'));
    }

    /**
     * Update current user data.
     *
     * @param int $id
     * @param UpdateUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(int $id, UpdateUserRequest $request)
    {
        $this->findOrFail($id)
            ->fill($request->all())
            ->save();

        return redirect()->route('show_user', [
            'id' => $id
        ]);
    }

    /**
     * Render page to show current user.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $user = $this->findOrFail($id);

        return view('rbac::users.show', compact('user'));
    }

    /**
     * Delete current user data.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(int $id)
    {
        $this->findOrFail($id)->delete();

        return redirect()->route('list_users');
    }

    /**
     * Find or fail user data.
     *
     * @param int $id
     * @return mixed
     */
    private function findOrFail(int $id)
    {
        return call_user_func([
            $this->userModelClass,
            'findOrFail',
        ], $id);
    }
}
