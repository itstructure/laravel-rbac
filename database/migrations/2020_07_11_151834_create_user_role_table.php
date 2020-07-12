<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Itstructure\LaRbac\Helpers\Helper;

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
    protected $userModelClass;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->userModelClass = config('rbac.userModelClass');
    }

    /**
     * Run the migrations.
     * @throws Exception
     * @throws \Exception
     */
    public function up()
    {
        Helper::checkUserModel($this->userModelClass);

        /* @var Illuminate\Foundation\Auth\User $userNewModel */
        $userNewModel = new $this->userModelClass();

        Helper::checkUserModelKeyType($userNewModel);

        $userModelTable = $userNewModel->getTable();

        $userModelKeyName = $userNewModel->getAuthIdentifierName();

        $userTablePrimaryType = Schema::getConnection()->getDoctrineColumn($userModelTable, $userModelKeyName)->getType()->getName();

        Helper::checkUserTablePrimaryType($userTablePrimaryType, $userModelKeyName, $userModelTable);

        Schema::create('user_role', function (Blueprint $table) use ($userModelKeyName, $userModelTable, $userTablePrimaryType) {
            switch ($userTablePrimaryType) {
                case 'bigint':
                    $table->unsignedBigInteger('user_id');
                    break;
                case 'integer':
                    $table->unsignedInteger('user_id');
                    break;
            }
            $table->unsignedInteger('role_id');
            $table->timestamps();
            $table->unique(['user_id','role_id']);
            $table->foreign('user_id')->references($userModelKeyName)->on($userModelTable)->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_role');
    }
}
