<?php

namespace App\Services;

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

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $image
     * @return bool
     */
    public function saveUser(string $firstName, string $lastName, string $image, string $email, string $password) {
        return $this->userRepository->saveUser(
            $firstName,
            $lastName,
            $image,
            $email,
            $password
        );
    }

    /**
     * @return mixed
     */
    public function getAllUsers() {
        return $this->userRepository->getAllUsers();
    }
}
