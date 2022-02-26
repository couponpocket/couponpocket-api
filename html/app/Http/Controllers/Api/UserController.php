<?php

namespace App\Http\Controllers\Api;

use App\Core\Controllers\Api\ApiController;
use App\Core\Traits\DestroyingTrait;
use App\Core\Traits\IndexPaginationTrait;
use App\Core\Traits\ShowingTrait;
use App\Core\Traits\StoringTrait;
use App\Core\Traits\UpdatingTrait;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
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
        ShowingTrait;

    use StoringTrait {
        store as baseStore;
    }

    use UpdatingTrait {
        update as baseUpdate;
    }

    use DestroyingTrait {
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
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();
        $user = User::findOrFail($id);

        if ($currentUser->id == $user->id) {
            throw new AccessDeniedHttpException("A user cannot delete himself");
        }

        return $this->baseDestroy($id);
    }
}
