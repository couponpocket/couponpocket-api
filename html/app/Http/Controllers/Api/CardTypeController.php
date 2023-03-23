<?php

namespace App\Http\Controllers\Api;

use App\Core\Controllers\Api\ApiController;
use App\Core\Traits\IndexTrait;
use App\Http\Requests\CardType\IndexCardTypeRequest;
use App\Models\CardType;
use Illuminate\Http\JsonResponse;

/**
 * @property CardType $modelInUse
 * @property CardType|string $modelClass
 */
class CardTypeController extends ApiController
{
    use IndexTrait {
        index as baseIndex;
    }

    protected string $modelClass = CardType::class;

    /**
     * @param IndexCardTypeRequest $request
     * @return JsonResponse
     */
    public function index(IndexCardTypeRequest $request): JsonResponse
    {
        return $this->baseIndex($request);
    }
}
