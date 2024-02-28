<?php 

namespace App\Repositories;

interface UserRepositoryInterface {
    /**
     * @param string $email
     * @return mixed
     */
    public function getUserDetailByEmail(string $email);

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $image
     * @param string $email
     * @param string $password
     * @return mixed
     */
    public function saveUser(string $firstName, string $lastName, string $image, string $email, string $password);

    /**
     * @return mixed
     */
    public function getAllUsers();    
}