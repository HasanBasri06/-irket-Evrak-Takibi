<?php

namespace App\Repositories;

interface UserRepositoryInterface {
    /**
     * @param string $email
     * @return mixed
     */
    public function getUserDetailByEmail(string $email);

    /**
     * @param $userData
     */
    public function saveUser($userData);

    /**
     * @return mixed
     */
    public function getAllUsers();

    /**
     * @param int $companyId
     * @return mixed
     */
    public function getCompanyDetailById(int $companyId);
}
