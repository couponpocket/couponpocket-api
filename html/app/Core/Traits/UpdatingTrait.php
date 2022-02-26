<?php

namespace App\Core\Traits;

use App\Core\Models\BaseModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

/**
 * @property ?BaseModel $modelInUse
 * @method BaseModel getModelById(string $id)
 */
trait UpdatingTrait
{
    /**
     * @param string $id
     * @param FormRequest $request
     * @return JsonResponse
     */
    public function update(string $id, FormRequest $request): JsonResponse
    {
        $model = $this->getModelById($id);
        $model->fill($request->validated());
        $model->update();

        $this->modelInUse = $model;

        return response()->json($model);
    }
}
