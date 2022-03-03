<?php

namespace App\Core\Traits;

use App\Core\Models\BaseModel;
use App\Core\Requests\StoreRequest;
use Illuminate\Http\JsonResponse;

/**
 * @property ?BaseModel $modelInUse
 * @method BaseModel createModelFromClass()
 */
trait StoreTrait
{
    /**
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $model = $this->createModelFromClass();
        $model->fill($request->validated());
        $model->save();

        // so our child controllers could modify it, if needed
        $this->modelInUse = $model;

        return response()->json($model);
    }
}
