<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRepository extends Repository
{
    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new User();
    }

    /**
     * find user by email
     *
     * @param string $email
     * @return User
     */
    public function findByEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
    }

    /**
     * update profile by user login
     *
     * @param array $data
     * @return int
     */
    public function updateProfile(array $data)
    {
        return $this->model->where('id', auth()->id())->update($data);
    }

    /**
     * get users data
     *
     * @return Collection
     */
    public function getUsers()
    {
        $users = $this->model->with(['roles'])->get();
        // dd($users);
        return $users;
    }

    /**
     * get all role data
     *
     * @return Collection
     */
    public function getRoles()
    {
        $roles = Role::all();
        return $roles;
    }

    /**
     * get all permission data
     *
     * @return Collection
     */
    public function getPermissions()
    {
        $permissions = Permission::all();
        return $permissions;
    }

    /**
     * update role data
     *
     * @param int $roleId
     * @param array $data
     * @return int
     */
    public function updateRole(int $roleId, array $data)
    {
        if (isset($data['permissions'])) {
            $role = Role::find($roleId);
            $permissions = Permission::whereIn('name', $data['permissions'])->get();
            $role->syncPermissions($permissions);
        }
    }

    /**
     * get all user where role owner boarding house data
     *
     * @return Collection
     */
    public function getOwnerOptions()
    {
        $owners = $this->model->role('pemilik kos')->get();
        return $owners->pluck('name', 'id')->toArray();
    }
}
