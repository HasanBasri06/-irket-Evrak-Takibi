<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @param UserService $userService
     */
    public function __construct(
        protected UserService $userService,
    )
    {
        $this->userService = $userService;
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request) {
        $email = $request->get('email');
        $password = $request->get('password');

        $isHasUser = $this->userService->isHasUser($email, $password);

        if ($isHasUser) {
            return response()->json([
                'message' => 'Kullanıcı giriş bilgileri doğru.',
                'user' => $isHasUser,
                'token' => $isHasUser->api_token
            ], 200);
        }

        return response()->json([
            'message' => 'Girdiğiniz bilgiler ile uyuşan bir profil bulunamadı'
        ], 404);
    }

    /**
     * @param RegisterRequest $request
     * @return bool
     */
    public function register(RegisterRequest $request) {
        return $this->userService->saveUser(
            $request->get('first_name'),
            $request->get('last_name'),
            $request->get('image'),
            $request->get('email'),
            $request->get('password'),
        );
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSingleUser(User $user) {
        return response()->json([
            'user' => $user,
            'message' => 'kullanıcı başarılı bir şekilde listelendi'
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllUsers() {
        $allUsers = $this->userService->getAllUsers();

        return response()->json([
            'data' => UserResource::collection($allUsers),
            'message' => 'kullanıcılar başarılı bir şekilde listelendi'
        ]);
    }
}