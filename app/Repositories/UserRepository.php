<?php 

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserRepository implements UserRepositoryInterface {
    /**
     * @param User $user
     */
    public function __construct(
        protected User $user,
    )
    {
        $this->user = $user;
    }
    
    public function getUserDetailByEmail(string $email)
    {
        return $this->user
            ->where('email', $email)
            ->first();
    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $image
     * @return JsonResponse
     */
    public function saveUser(string $firstName, string $lastName, string $image, string $email, string $password) {

        $isHasUser = $this->getUserDetailByEmail($email);

        if (is_null($isHasUser)) {
            $user = $this->user->create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'image' => $image,
                'email' => $email,
                'password' => bcrypt($password),
            ]);

            $token = $user->createToken('api_token')->plainTextToken;

            $user->update([
                'api_token' => $token
            ]);
        
            return response()->json([
                'token' => $token,
                'user' => $user
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
}