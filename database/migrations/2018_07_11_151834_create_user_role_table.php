<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Itstructure\LaRbac\Helpers\Helper;
use Itstructure\LaRbac\Exceptions\InvalidConfigException;

/**
 * Class CreateUserRoleTable
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class CreateUserRoleTable extends Migration
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
     * Run the migrations.
     *
     * @return void
     * @throws InvalidConfigException
     */
    public function up()
    {
        /* @var Illuminate\Foundation\Auth\User $userModel */
        $userModel = new $this->userModelClass();

        $userModelKeyType = $userModel->getKeyType();

        if ($userModelKeyType !== 'int') {
            throw new InvalidConfigException('User Model keyType must be int.');
        }

        $userModelKeyName = $userModel->getKeyName();

        $userModelTable = $userModel->getTable();

        Schema::create('user_role', function (Blueprint $table) use ($userModelKeyName, $userModelTable) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('role_id');
            $table->timestamps();
            $table->unique(['user_id','role_id']);
            $table->foreign('user_id')->references($userModelKeyName)->on($userModelTable)->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_role');
    }
}
