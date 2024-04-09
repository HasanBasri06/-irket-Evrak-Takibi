<?php

namespace App\Repositories;

use App\Enums\IsActive;
use App\Models\Company;
use App\Models\CompanyWorker;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface {
    /**
     * @param User $user
     * @param Company $company
     * @param CompanyWorker $companyWorker
     */
    public function __construct(
        protected User $user,
        private Company $company,
        private CompanyWorker $companyWorker,
    )
    {
        $this->user = $user;
        $this->company = $company;
        $this->companyWorker = $companyWorker;
    }

    public function getUserDetailByEmail(string $email)
    {
        return $this->user
            ->where('email', $email)
            ->first();
    }

    /**
     * @param $userData
     */
    public function saveUser($userData) {

        $isHasUser = $this->getUserDetailByEmail($userData['email']);

        if (is_null($isHasUser)) {
            $user = $this->user->create([
                'first_name' => $userData['first_name'],
                'last_name' => $userData['last_name'],
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
            ]);

            $token = $user->createToken('api_token')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $user,
                'message' => 'Kullanıcı başarılı bir şekilde eklendi',
            ], 201);
        }

        return response()->json([
            'message' => 'Kullanıcı sistemimizde zaten mevcut.'
        ], 200);
    }

    /**
     * @return mixed
     */
    public function getAllUsers() {
        return $this->user->get();
    }

    /**
     * @param integer $companyId
     * @return Company
     */
    public function getCompanyDetailById(int $companyId): Company
    {
        return $this->company
            ->where('id', $companyId)
            ->first();
    }
}
