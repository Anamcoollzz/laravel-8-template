<?php

namespace App\Repositories;

use App\Models\PermissionGroup;
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
     * find user by email token
     *
     * @param string $emailToken
     * @return User
     */
    public function findByEmailToken(string $emailToken)
    {
        return $this->model->where('email_token', $emailToken)->first();
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
     * findRole
     *
     * @param integer $roleId
     * @return Role
     */
    public function findRole(int $roleId)
    {
        return Role::where('id', $roleId)->with(['permissions'])->first();
    }

    /**
     * create role data
     *
     * @param string $roleName
     * @param array $data
     * @return int
     */
    public function createRole(string $roleName, array $data)
    {
        if (isset($data['permissions'])) {
            $role        = Role::create(['name' => $roleName]);
            $permissions = Permission::whereIn('name', $data['permissions'])->get();
            $role        = Role::find($role->id);
            $role->syncPermissions($permissions);
            return $role;
        }
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
            $role        = Role::find($roleId);
            $permissions = Permission::whereIn('name', $data['permissions'])->get();
            $role->syncPermissions($permissions);
            return $role;
        }
    }

    /**
     * delete role data
     *
     * @param int $roleId
     * @return int
     */
    public function deleteRole(int $roleId)
    {
        return Role::where('id', $roleId)->delete();
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

    /**
     * get permission group with child
     *
     * @return Collection
     */
    public function getPermissionGroupWithChild()
    {
        return PermissionGroup::with(['permissions'])->get();
    }
}
