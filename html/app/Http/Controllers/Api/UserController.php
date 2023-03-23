<?php

namespace App\Http\Controllers\Api;

use App\Core\Controllers\Api\ApiController;
use App\Core\Traits\DestroyTrait;
use App\Core\Traits\IndexPaginationTrait;
use App\Core\Traits\ShowTrait;
use App\Core\Traits\StoreTrait;
use App\Core\Traits\UpdateTrait;
use App\Http\Requests\User\DestroyUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

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
     * @param DestroyUserRequest $request
     * @return JsonResponse
     */
    public function destroy($id, DestroyUserRequest $request): JsonResponse
    {
        return $this->baseDestroy($id, $request);
    }
}
