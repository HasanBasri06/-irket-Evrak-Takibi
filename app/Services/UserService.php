<?php

namespace App\Services;

use App\Jobs\UserLoginSendEmail;
use App\Repositories\UserRepositoryInterface;

class UserService {
    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        protected UserRepositoryInterface $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $email
     * @return bool
     */
    public function isHasUser(string $email) {
        return $this->userRepository->getUserDetailByEmail($email);
    }

    public function saveUser($userData) {
         return $this->userRepository->saveUser($userData);
    }

    /**
     * @return mixed
     */
    public function getAllUsers() {
        return $this->userRepository->getAllUsers();
    }

    /**
     * @param string $email
     * @param integer $companyId
     * @return void
     */
    public function getUserByDetail(string $email, string $role, int $companyId) {
        $getCompanyDetailById = $this->userRepository->getCompanyDetailById($companyId);

        dispatch(new UserLoginSendEmail($role, $email, $companyId));
    }
}
