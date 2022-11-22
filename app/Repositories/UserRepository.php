<?php

namespace App\Repositories;

use App\Models\ActivityLog;
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
     * get user id login
     *
     * @return int
     */
    public function getUserIdLogin()
    {
        return auth()->id() ?? auth('api')->id();
    }

    /**
     * set and get user login
     *
     * @return User
     */
    public function login(User $user)
    {
        auth()->login($user, request()->filled('remember'));
        $user->update(['last_login' => now()]);
        logLogin();
        return $user;
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
     * find user by twitter id
     *
     * @param string $twitterId
     * @return User
     */
    public function findByTwitterId(string $twitterId)
    {
        return $this->model->where('twitter_id', $twitterId)->first();
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
        $userId = $this->getUserIdLogin();
        $this->model->where('id', $userId)->update($data);
        return $this->find($userId);
    }

    /**
     * get users data
     *
     * @return Collection
     */
    public function getUsers()
    {
        $users = $this->model->with(['roles'])->latest()->get();
        return $users;
    }

    /**
     * get user as option dropdown
     *
     * @return array
     */
    public function getUserOptions()
    {
        return $this->getUsers()
            ->pluck('name', 'id')
            ->toArray();
    }

    /**
     * get user data as pagination
     *
     * @param integer $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginateUsers($perPage = 20)
    {
        $users = $this->model->with(['roles'])->latest()->paginate($perPage);
        return $users;
    }

    /**
     * get all role data
     *
     * @return Collection
     */
    public function getRoles()
    {
        $roles = Role::with(['permissions'])->get();
        return $roles;
    }

    /**
     * get role as option dropdown
     *
     * @return array
     */
    public function getRoleOptions()
    {
        return $this->getRoles()
            ->pluck('name', 'id')
            ->toArray();
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
            $role        = Role::create([
                'name'       => $roleName,
                'guard_name' => 'web'
            ]);
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

    /**
     * getLogActivitiesPaginate
     *
     * @param integer $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getLogActivitiesPaginate($perPage = 20)
    {
        return ActivityLog::query()
            ->where('user_id', $this->getUserIdLogin())
            ->latest()
            ->paginate($perPage);
    }
}
