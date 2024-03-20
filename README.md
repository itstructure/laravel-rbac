# Laravel RBAC package

[![Latest Stable Version](https://poser.pugx.org/itstructure/laravel-rbac/v/stable)](https://packagist.org/packages/itstructure/laravel-rbac)
[![Latest Unstable Version](https://poser.pugx.org/itstructure/laravel-rbac/v/unstable)](https://packagist.org/packages/itstructure/laravel-rbac)
[![License](https://poser.pugx.org/itstructure/laravel-rbac/license)](https://packagist.org/packages/itstructure/laravel-rbac)
[![Total Downloads](https://poser.pugx.org/itstructure/laravel-rbac/downloads)](https://packagist.org/packages/itstructure/laravel-rbac)
[![Build Status](https://scrutinizer-ci.com/g/itstructure/laravel-rbac/badges/build.png?b=master)](https://scrutinizer-ci.com/g/itstructure/laravel-rbac/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/itstructure/laravel-rbac/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/itstructure/laravel-rbac/?branch=master)

## 1 Introduction

**LaRbac** - Package for the Laravel framework which provides management with the next data:
- Roles
- Permissions
- Assign roles for users

![RBAC package structure](https://github.com/itstructure/laravel-rbac/blob/master/laravel_rbac_structure_en.jpg)

## 2 Dependencies

- laravel 8+ | 9+ | 10+ | 11+
- Bootstrap 4 for styling
- JQuery
- php >= 7.3.0
- composer

## 3 Installation

**Note!**

Version **3.x** is for laravel **8+**, **9+**, **10+**, **11+**.

Version **2.x** is for laravel **6** or **7**. You can use branch `laravel67-rbac` with **2.x** versions.

### 3.1 General installation from remote repository

Run the composer command:

`composer require itstructure/laravel-rbac "~3.0.12"`

### 3.2 Next internal installation steps

**Notes:**

- Make sure that a table for the users is already existing in your project.

- Make sure that a model for the users table is already existing in your project.

**Recommendation:**

If you don't have any layout yet, it is useful to install for example [AdminLTE](https://github.com/jeroennoten/Laravel-AdminLTE) 
or you can make your special any layout template. 
Cause in this package there is no a layout specially. But in config it is necessary to set it (see the next point 2 about a configure).

Let's go:

1. Publish files.

    **Note:** `rbac.php` config file and seeders `LaRbacDatabaseSeeder`, `PermissionSeeder`, `RoleSeeder` must be published surely!

    - To publish config run command:
    
        `php artisan rbac:publish --only=config`
        
        It stores config file to `config` folder.
        
    - To publish seeders run command:
        
        `php artisan rbac:publish --only=seeders`
        
        It stores seeder files to `database/seeders` folder.
        
    - To publish migrations run command:
            
        `php artisan rbac:publish --only=migrations`
        
        It stores migration files to `database/migrations` folder.
            
    - To publish views run command:
                
        `php artisan rbac:publish --only=views`
        
        It stores view files to `resources/views/vendor/rbac` folder.
        
    - To publish translations run command:
                    
        `php artisan rbac:publish --only=lang`
        
        It stores translation files to `resources/lang/vendor/rbac` folder.
        
    - To publish all parts run command without `only` argument:
    
        `php artisan rbac:publish`
        
    Else you can use `--force` argument to rewrite already published files.
    
2. Configure published `config/rbac.php` file:

    - set `layout`. Example: `'layout' => 'adminlte::page'`
    
    - change `userModelClass` if it is needed to change
    
    - set `adminUserId` which you wanted to be with the role of administrator. **At least at the beginning stage**.
    
        It is necessary for the next time system to let you go into the Rbac control panel, after you assigned an administrator role for you (Later see point **4**).
        
    - Most likely you have to change `memberNameAttributeKey`.
    
        It is to display the user name in control panel by `getMemberNameAttribute()` method of `Administrable` trait. It can be **string** or a **callback**:
    
        ```php
        'memberNameAttributeKey' => function ($row) {
            return $row->first_name . ' ' . $row->last_name;
        }
        ```
    
3. Run command to run migrations and seeders:

    `php artisan rbac:database`
    
    Or optional:
    
    To run just migrations `php artisan rbac:database --only=migrate`
    
    To run just seeds `php artisan rbac:database --only=seed`
    
    - Alternative variant for seeders.
    
        You can set published rbac `LaRbacDatabaseSeeder` seeder class in to a special `DatabaseSeeder`:
            
        ```php
        use Illuminate\Database\Seeder;
        ```
        
        ```php
        class DatabaseSeeder extends Seeder
        {
            public function run()
            {
                $this->call(LaRbacDatabaseSeeder::class);
            }
        }
        ```
        
        and run command: `php artisan db:seed`.
    
4. Run command to set Admin role for user with identifier `adminUserId`, defined in **2** point:

    `php artisan rbac:admin`

## 4 Usage

**Notes**:

- Make sure you use a **Bootstrap 4** for styling and **JQuery** in your application.

- Make sure that a laravel initial factory authorization is already working in your application.

### 4.1 Model part

According with the `Itstructure\LaRbac\Interfaces\RbacUserInterface` use functions from `Itstructure\LaRbac\Traits\Administrable` trait as in example:

```php
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Itstructure\LaRbac\Interfaces\RbacUserInterface;
use Itstructure\LaRbac\Traits\Administrable;
```

```php
class User extends Authenticatable implements RbacUserInterface
{
    use Notifiable, Administrable;

    protected $fillable = [
        'name', 'email', 'password', 'roles'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
```

### 4.2 Routes part

There are already integrated base RBAC routes to manage **users**, **roles** and **permissions**. See in `routes.php` package file.

They are guarded by the next:

- middleware `auth` (editable by config).
- permission `can:administrate` (editable by config).

This routes allow you to go to the next routes:

- **Users section**

    For get request method

    - `http://example-domain.com/rbac/users`
    - `http://example-domain.com/rbac/users/show/{id}`
    - `http://example-domain.com/rbac/users/edit/{id}`

    For post request method

    - `http://example-domain.com/rbac/users/update/{id}`
    - `http://example-domain.com/rbac/users/delete`
    
- **Roles section**

    For get request method

    - `http://example-domain.com/rbac/roles`
    - `http://example-domain.com/rbac/roles/show/{id}`
    - `http://example-domain.com/rbac/roles/create`
    - `http://example-domain.com/rbac/roles/edit/{role}`

    For post request method

    - `http://example-domain.com/rbac/roles/store`
    - `http://example-domain.com/rbac/roles/update/{role}`
    - `http://example-domain.com/rbac/roles/delete`
    
- **Permissions section**

    For get request method

    - `http://example-domain.com/rbac/permissions`
    - `http://example-domain.com/rbac/permissions/show/{id}`
    - `http://example-domain.com/rbac/permissions/create`
    - `http://example-domain.com/rbac/permissions/edit/{permission}`

    For post request method

    - `http://example-domain.com/rbac/permissions/store`
    - `http://example-domain.com/rbac/permissions/update/{permission}`
    - `http://example-domain.com/rbac/permissions/delete`

### 4.3 Gates part

There are already integrated base RBAC gates to access control in your application to some of the resources. See provider file `RbacAuthServiceProvider.php`.

It provides the next gate definitions:

- `administrate`
- `assign-role`
- `delete-member`
- `view-record`
- `create-record`
- `update-record`
- `delete-record`
- `publish-record`

Read more in [Laravel gates](https://laravel.com/docs/9.x/authorization#gates)

## 5 View examples

**Users**

![RBAC package structure](https://github.com/itstructure/laravel-rbac/blob/master/laravel_rbac_users_en.JPG)

**Roles**

![RBAC package structure](https://github.com/itstructure/laravel-rbac/blob/master/laravel_rbac_roles_en.JPG)

**Permissions**

![RBAC package structure](https://github.com/itstructure/laravel-rbac/blob/master/laravel_rbac_permissions_en.JPG)

## License

Copyright © 2018-2024 Andrey Girnik girnikandrey@gmail.com.

Licensed under the [MIT license](http://opensource.org/licenses/MIT). See LICENSE.txt for details.
