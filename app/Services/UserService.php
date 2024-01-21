<?php

namespace App\Services;

use App\Dto\ConfirmUserDto;
use App\Repositories\UserRepository;
use App\Dto\CreateUserDto;
use App\Dto\ForgetPasswordDto;
use App\Dto\LoginUserDto;
use App\Dto\ResendCodeDto;
use App\Dto\ResetPasswordDto;
use App\Exceptions\CredentialsIncorrectException;
use App\Exceptions\InternalServerErrorException;
use App\Exceptions\OTPInvalidexception;
use App\Exceptions\UserAlreadyExistsException;
use App\Exceptions\UserNotActiveException;
use App\Exceptions\UserNotFoundException;
use App\Mail\ConfirmAccount;
use App\Mail\ForgetPassword;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserService
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createUser(CreateUserDto $createUserDto)
    {
        $user = $this->repository->findByEmail($createUserDto->email);

        if ($user) {
            throw new UserAlreadyExistsException();
        }

        $user = $this->repository->create([
            'name' => $createUserDto->name,
            'email' => $createUserDto->email,
            'password' => Hash::make($createUserDto->password),
            'email_confirm_code' => rand(pow(10, 3), pow(10, 4) - 1),
            'expire_confirm_code_at' => Carbon::now()->addMinutes(15)->toDateTimeString(),
        ]);

        $data = array(
            'name' => $createUserDto->name,
            'code' => $user->email_confirm_code,
        );

        Mail::to($createUserDto->email)->send(new ConfirmAccount($data));

        return $user;
    }

    public function loginUser(LoginUserDto $loginUserDto)
    {
        $user = $this->repository->findByEmail($loginUserDto->email);

        if (!$user) {
            throw new UserNotFoundException();
        }

        if (!Hash::check($loginUserDto->password, $user->password)) {
            throw new CredentialsIncorrectException();
        }

        if (!$user->active) {
            throw new UserNotActiveException();
        }

        return $user;
    }

    public function confirmUser(ConfirmUserDto $confirmUserDto)
    {
        $user = $this->repository->findByEmail($confirmUserDto->email);

        if (!$user) {
            throw new UserNotFoundException();
        }

        if ($user->email_verified_at !== null) {
            return $user;
        }

        if ($confirmUserDto->code !== $user->email_confirm_code || Carbon::now()->gt(Carbon::parse($user->expire_confirm_code_at))) {
            throw new OTPInvalidexception();
        }

        $inputs = [
            'active' => 1,
            'email_verified_at' => Carbon::now(),
        ];

        $result = $this->repository->update($user->id, $inputs);

        if (!$result) {
            throw new InternalServerErrorException();
        }

        return $user;
    }

    public function forgetPassword(ForgetPasswordDto $forgetPasswordDto)
    {
        $user = $this->repository->findByEmail($forgetPasswordDto->email);

        if (!$user) {
            throw new UserNotFoundException();
        }

        $email_confirm_code = rand(pow(10, 3), pow(10, 4) - 1);

        $inputs = [
            'email' => $forgetPasswordDto->email,
            'email_confirm_code' => $email_confirm_code,
        ];

        $result = $this->repository->update($user->id, $inputs);

        if (!$result) {
            throw new InternalServerErrorException();
        }

        $data = array(
            'name' => $user->name,
            'code' => $email_confirm_code,
        );

        $data = array(
            'name' => $user->name,
            'code' => $email_confirm_code,
        );

        Mail::to($forgetPasswordDto->email)->send(new ForgetPassword($data));

        return $user;
    }

    public function resendConfirmationCode(ResendCodeDto $resendCodeDto)
    {
        $user = $this->repository->findByEmail($resendCodeDto->email);

        if (!$user) {
            throw new UserNotFoundException();
        }

        $email_confirm_code = rand(pow(10, 3), pow(10, 4) - 1);

        $inputs = [
            'email' => $resendCodeDto->email,
            'email_confirm_code' => $email_confirm_code,
            'expire_confirm_code_at' => Carbon::now()->addMinutes(15)->toDateTimeString(),
        ];

        $result = $this->repository->update($user->id, $inputs);

        if (!$result) {
            throw new InternalServerErrorException();
        }

        $data = array(
            'name' => $user->name,
            'code' => $email_confirm_code,
        );

        Mail::to($resendCodeDto->email)->send(new ConfirmAccount($data));

        return $user;
    }

    public function resetPassword(ResetPasswordDto $resetPasswordDto)
    {
        $user = $this->repository->findByEmail($resetPasswordDto->email);

        if (!$user) {
            throw new UserNotFoundException();
        }

        if ($user->email_confirm_code !== $resetPasswordDto->code) {
            throw new OTPInvalidexception();
        }

        $inputs = [
            'password' => Hash::make($resetPasswordDto->password),
        ];

        $result = $this->repository->update($user->id, $inputs);

        if (!$result) {
            throw new InternalServerErrorException();
        }

        return $user;
    }
}
