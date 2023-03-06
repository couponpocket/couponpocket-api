<?php

namespace App\Http\Controllers\Api;

use App\Core\Controllers\Api\ApiController;
use App\Core\Traits\StoreTrait;
use App\Http\Requests\Auth\EmailVerificationRequest;
use App\Http\Requests\Auth\EmailVerificationResendRequest;
use App\Http\Requests\Auth\GenerateTokenRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * @property User $modelInUse
 * @property User|string $modelClass
 */
class AuthController extends ApiController
{
    use StoreTrait {
        store as baseStore;
    }

    protected string $modelClass = User::class;

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $this->baseStore($request);

        return response()->json([
            'access_token' => $this->modelInUse->createToken('auth-token')->plainTextToken
        ]);
    }

    /**
     * @param EmailVerificationRequest $request
     * @return JsonResponse
     */
    public function verify(EmailVerificationRequest $request): JsonResponse
    {
        $request->user()->markEmailAsVerified();

        event(new Verified($request->user()));

        return new JsonResponse([], 204);
    }

    /**
     * @param EmailVerificationResendRequest $request
     * @return JsonResponse
     */
    public function resend(EmailVerificationResendRequest $request): JsonResponse
    {
        $request->user()->sendEmailVerificationNotification();

        return new JsonResponse([], 204);
    }

    /**
     * @param GenerateTokenRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function generateToken(GenerateTokenRequest $request): JsonResponse
    {
        $user = User::where('email', $request->input('email'))->first();

        return response()->json([
            'user' => $user,
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
        /** @noinspection PhpPossiblePolymorphicInvocationInspection */
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Tokens Revoked'
        ]);
    }
}
