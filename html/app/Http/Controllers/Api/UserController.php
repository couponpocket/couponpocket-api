<?php

namespace App\Http\Controllers\Api;

use App\Core\Controllers\Api\ApiController;
use App\Core\Requests\DestroyRequest;
use App\Core\Traits\DestroyTrait;
use App\Core\Traits\IndexPaginationTrait;
use App\Core\Traits\ShowTrait;
use App\Core\Traits\StoreTrait;
use App\Core\Traits\UpdateTrait;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * @property User $modelInUse
 * @property User|string $modelClass
 */
class UserController extends ApiController
{
    use IndexPaginationTrait,
        ShowTrait;

    use StoreTrait {
        store as baseStore;
    }

    use UpdateTrait {
        update as baseUpdate;
    }

    use DestroyTrait {
        destroy as baseDestroy;
    }

    protected string $modelClass = User::class;

    /**
     * @return JsonResponse
     */
    public function authorizedUser(): JsonResponse
    {
        return response()->json(Auth::user());
    }

    /**
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        return $this->baseStore($request);
    }

    /**
     * @param $id
     * @param UpdateUserRequest $request
     * @return JsonResponse
     */
    public function update($id, UpdateUserRequest $request): JsonResponse
    {
        return $this->baseUpdate($id, $request);
    }

    /**
     * @param $id
     * @param DestroyRequest $request
     * @return JsonResponse
     */
    public function destroy($id, DestroyRequest $request): JsonResponse
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();
        $user = User::findOrFail($id);

        if ($currentUser->id == $user->id) {
            throw new AccessDeniedHttpException("A user cannot delete himself");
        }

        return $this->baseDestroy($id, $request);
    }
}
