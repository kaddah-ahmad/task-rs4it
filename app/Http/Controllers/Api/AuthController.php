<?php

namespace App\Http\Controllers\Api;

use App\Dto\ConfirmUserDto;
use App\Http\Requests\LoginUserRquest;
use App\Http\Requests\RegisterUserRequest;
use App\Services\UserService;
use App\Dto\CreateUserDto;
use App\Dto\ForgetPasswordDto;
use App\Dto\LoginUserDto;
use App\Dto\ResendCodeDto;
use App\Dto\ResetPasswordDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConfirmAccountRequest;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\ResendConfrimationCodeRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    protected $service;

    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }

    public function register(RegisterUserRequest $request)
    {
        $createUserDto = new CreateUserDto(
            $request->input('name'),
            $request->input('email'),
            $request->input('password'),
        );

        $user = $this->service->createUser($createUserDto);

        return response()->json([
            'success' => true,
            'message' => 'user created successfully',
            'user' => new UserResource($user),
        ], 201);
    }

    public function login(LoginUserRquest $request)
    {
        $loginUserDto = new LoginUserDto(
            $request->input('email'),
            $request->input('password'),
        );

        $user = $this->service->loginUser($loginUserDto);

        return response()->json([
            'success' => true,
            'message' => 'user logged-in successfully',
            'token' => $user->createToken("API TOKEN")->plainTextToken,
            'user' => new UserResource($user),
        ], 200);
    }

    public function confirmAccount(ConfirmAccountRequest $request)
    {
        $confirmUserDto = new ConfirmUserDto(
            $request->input('email'),
            $request->input('code'),
        );

        $user = $this->service->confirmUser($confirmUserDto);

        return response()->json([
            'message' => 'user activated successfully',
            'user' => new UserResource($user),
        ], 200);
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        $forgetPasswordDto = new ForgetPasswordDto($request->input('email'));

        $user = $this->service->forgetPassword($forgetPasswordDto);

        return response()->json([
            'success' => true,
            'message' => 'send code to email successfully'
        ], 200);
    }

    public function resendConfirmationCode(ResendConfrimationCodeRequest $request)
    {
        $resendCodeDto = new ResendCodeDto($request->input('email'));

        $user = $this->service->resendConfirmationCode($resendCodeDto);

        return response()->json([
            'success' => true,
            'message' => 'resend code successfully',
        ], 200);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $resetPasswordDto = new ResetPasswordDto(
            $request->input('email'),
            $request->input('password'),
            $request->input('code'),
        );

        $user = $this->service->resetPassword($resetPasswordDto);

        return response()->json([
            'success' => true,
            'message' => 'reset password successfully',
        ], 200);
    }
}
