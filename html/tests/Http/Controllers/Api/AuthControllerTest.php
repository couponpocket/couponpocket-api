<?php

namespace Tests\Http\Controllers\Api;

use App\Models\User;
use App\Notifications\VerifyEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function testSuccessFullRegister()
    {
        /** @var User $user */
        $user = User::factory()->make();

        Event::fake([Registered::class]);

        $this->json('post', '/api/register', [
            'email' => $user->email,
            'name' => $user->name,
            'password' => 'password'
        ])
            ->assertOk()
            ->assertJsonStructure([
                'id',
                'name',
                'email'
            ]);

        Event::assertDispatchedTimes(Registered::class);

        // try again with the same email
        $this->json('post', '/api/register', [
            'email' => $user->email,
            'name' => $user->name,
            'password' => 'password'
        ])
            ->assertStatus(422)
            ->assertInvalid(['email']);

        $this->assertDatabaseCount('users', 1);
    }

    public function testMissingParamsOnRegister()
    {
        /** @var User $user */
        $user = User::factory()->make();

        $this->json('post', '/api/register', [
            'email' => $user->email,
            'name' => $user->name,
        ])
            ->assertStatus(422)
            ->assertInvalid([
                'password' => __('validation.required', ['attribute' => __('validation.attributes.password')])
            ]);

        $this->json('post', '/api/register', [
            'email' => $user->email,
            'password' => 'password'
        ])
            ->assertStatus(422)
            ->assertInvalid([
                'name' => __('validation.required', ['attribute' => __('validation.attributes.name')])
            ]);

        $this->json('post', '/api/register', [
            'name' => $user->name,
            'password' => 'password'
        ])
            ->assertStatus(422)
            ->assertInvalid([
                'email' => __('validation.required', ['attribute' => __('validation.attributes.email')])
            ]);

        $this->assertDatabaseCount('users', 0);
    }

    public function testInvalidEmailOnRegister()
    {
        /** @var User $user */
        $user = User::factory()->make();

        $this->json('post', '/api/register', [
            'email' => 'invalid.address',
            'name' => $user->name,
            'password' => 'password'
        ])
            ->assertStatus(422)
            ->assertInvalid([
                'email' => __('validation.email', ['attribute' => __('validation.attributes.email')])
            ]);

        $this->assertDatabaseCount('users', 0);
    }

    public function testSuccessTokenValidation()
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email_verified_at' => null
        ]);

        // get the token
        $token = $this->json('post', '/api/token', [
            'email' => $user->email,
            'password' => 'password'
        ])
            ->assertOk()
            ->assertJsonStructure(['access_token'])
            ->json('access_token');

        $this->assertIsString($token);

        // user is not activated whe should not able to fetch resources, only the token
        $this->json('get', '/api/ping/auth-verified', [], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $this->json('post', '/api/email/verify', [
            'code' => $user->getEmailValidationCode()
        ], [
            'Authorization' => 'Bearer ' . $token
        ])
            ->assertNoContent();

        // just validate token
        $this->json('get', '/api/ping/auth-verified', [], [
            'Authorization' => 'Bearer ' . $token
        ])
            ->assertOk();
    }

    public function testFailedTokenValidation()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->json('post', '/api/token', [
            'email' => $user->email,
            'password' => 'notthesamepassword'
        ])
            ->assertStatus(422);
    }

    public function testResendVerificationMail()
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email_verified_at' => null
        ]);
        $token = $user->createToken('auth-token')->plainTextToken;

        Notification::fake();

        $this->json('post', '/api/email/resend', [], [
            'Authorization' => 'Bearer ' . $token
        ])->assertStatus(202);

        Notification::assertTimesSent(1, VerifyEmail::class);
    }

    public function testLogout()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $token = $user->createToken('auth-token')->plainTextToken;

        $this->json('post', '/api/remove-token', [], [
            'Authorization' => 'Bearer ' . $token
        ])
            ->assertOk();
    }

    public function testForgotPassword()
    {
        /** @var User $user */
        $user = User::factory()->create();

        Notification::fake();

        $this->json('post', '/api/forgot-password', [
            'email' => $user->email
        ])
            ->assertOk();

        Notification::assertTimesSent(1, ResetPasswordNotification::class);
    }

    public function testResetPassword()
    {
        /** @var User $user */
        $user = User::factory()->create();

        Password::broker()->sendResetLink(['email' => $user->email]);
        $token = Password::broker()->createToken($user);

        $this->json('post', '/api/reset-password', [
            'token' => $token,
            'email' => $user->email,
            'password' => 'newpassword'
        ])
            ->assertOk();
    }
}

