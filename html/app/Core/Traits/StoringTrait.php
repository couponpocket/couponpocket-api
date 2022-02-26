<?php

namespace App\Core\Traits;

use App\Core\Models\BaseModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

/**
 * @property ?BaseModel $modelInUse
 * @method BaseModel createModelFromClass()
 */
trait StoringTrait
{
    /**
     * @param FormRequest $request
     * @return JsonResponse
     */
    public function store(FormRequest $request): JsonResponse
    {
        $model = $this->createModelFromClass();
        $model->fill($request->validated());
        $model->save();

        // so our child controllers could modify it, if needed
        $this->modelInUse = $model;

        return response()->json($model);
    }
}
