<?php

namespace App\Core\Traits;

use App\Core\Models\BaseModel;
use App\Core\Requests\IndexRequest;
use Illuminate\Http\JsonResponse;

/**
 * @property BaseModel|string $modelClass
 */
trait IndexTrait
{
    /**
     * @param IndexRequest $request
     * @return JsonResponse
     */
    public function index(IndexRequest $request): JsonResponse
    {
        return response()->json($this->modelClass::all());
    }
}
