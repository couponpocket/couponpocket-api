<?php

namespace App\Http\Controllers\Api;

use App\Core\Controllers\Api\ApiController;
use App\Core\Traits\StoringTrait;
use App\Http\Requests\GenerateTokenRequest;
use App\Http\Requests\LogoutRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * @property User $modelInUse
 * @property User|string $modelClass
 */
class AuthController extends ApiController
{
    use StoringTrait {
        store as baseStore;
    }

    protected string $modelClass = User::class;

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        return $this->baseStore($request);
    }

    /**
     * @param EmailVerificationRequest $request
     * @return JsonResponse
     */
    public function verify(EmailVerificationRequest $request): JsonResponse
    {
        $request->fulfill();

        return new JsonResponse([], 204);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function resend(Request $request): JsonResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return new JsonResponse([], 204);
        }

        $request->user()->sendEmailVerificationNotification();

        return new JsonResponse([], 202);
    }

    /**
     * @param GenerateTokenRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function generateToken(GenerateTokenRequest $request): JsonResponse
    {
        $user = User::where('email', $request->input('email'))->first();

        if (!($user instanceof User) || !Hash::check($request->input('password'), $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
            'access_token' => $user->createToken('auth-token')->plainTextToken
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $result = Password::broker()->sendResetLink($request->only('email'));

        return $result == Password::RESET_LINK_SENT ?
            new JsonResponse([], 200) :
            new JsonResponse([], 400);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $result = Password::broker()->reset(
            $request->only(['token', 'email', 'password']),
            function (User $user, $password) {
                $user->password = $password;
                $user->setRememberToken(Str::random(60));
                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $result == Password::PASSWORD_RESET ?
            new JsonResponse([], 200) :
            new JsonResponse([], 400);
    }

    /**
     * @param LogoutRequest $request
     * @return JsonResponse
     */
    public function logout(LogoutRequest $request): JsonResponse
    {
        // Revoke the token that was used to authenticate the current request...
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Tokens Revoked'
        ]);
    }
}
