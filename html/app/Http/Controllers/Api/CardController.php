<?php

namespace App\Http\Controllers\Api;

use App\Core\Controllers\Api\ApiController;
use App\Core\Traits\DestroyTrait;
use App\Core\Traits\IndexTrait;
use App\Core\Traits\ShowTrait;
use App\Core\Traits\StoreTrait;
use App\Core\Traits\UpdateTrait;
use App\Http\Requests\Card\DestroyCardRequest;
use App\Http\Requests\Card\IndexCardRequest;
use App\Http\Requests\Card\ShowCardRequest;
use App\Http\Requests\Card\StoreCardRequest;
use App\Http\Requests\Card\UpdateCardRequest;
use App\Models\Card;
use App\Models\User;
use Illuminate\Http\JsonResponse;

/**
 * @property Card $modelInUse
 * @property Card|string $modelClass
 */
class CardController extends ApiController
{
    use IndexTrait {
        index as baseIndex;
    }

    use ShowTrait {
        show as baseShow;
    }

    use StoreTrait {
        store as baseStore;
    }

    use UpdateTrait {
        update as baseUpdate;
    }

    use DestroyTrait {
        destroy as baseDestroy;
    }

    protected string $modelClass = Card::class;

    /**
     * @param IndexCardRequest $request
     * @return JsonResponse
     */
    public function index(IndexCardRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $sortKey = $request->input('sortKey', $this->getDefaultSortKey());
        $sortOrder = $request->input('sortOrder', 'asc');

        return response()->json($user->cards()->orderBy($sortKey, $sortOrder)->get());
    }

    /**
     * @param string $id
     * @param ShowCardRequest $request
     * @return JsonResponse
     */
    public function show(string $id, ShowCardRequest $request): JsonResponse
    {
        return $this->baseShow($id, $request);
    }

    /**
     * @param StoreCardRequest $request
     * @return JsonResponse
     */
    public function store(StoreCardRequest $request): JsonResponse
    {
        return $this->baseStore($request);
    }

    /**
     * @param $id
     * @param UpdateCardRequest $request
     * @return JsonResponse
     */
    public function update($id, UpdateCardRequest $request): JsonResponse
    {
        return $this->baseUpdate($id, $request);
    }

    /**
     * @param $id
     * @param DestroyCardRequest $request
     * @return JsonResponse
     */
    public function destroy($id, DestroyCardRequest $request): JsonResponse
    {
        return $this->baseDestroy($id, $request);
    }
}
