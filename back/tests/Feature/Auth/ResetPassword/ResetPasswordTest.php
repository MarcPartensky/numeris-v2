<?php

namespace Tests\Feature\Auth\ForgotPassword;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    /**
     * @group any
     */
    public function testResetPassword()
    {
        $user = $this->activeUserProvider();

        $data = [
            'email'                 => $user->email,
            'password'              => 'azertyuiopq',
            'password_confirmation' => 'azertyuiopq',
            'token'                 => Password::broker()->createToken($user)
        ];
        $this->json('POST', route('password.reset'), $data)
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJson(['message' => [trans('passwords.reset')]]);
    }
}