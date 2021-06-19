<?php

namespace App\Repositories;

use App\Models\User;

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
}
