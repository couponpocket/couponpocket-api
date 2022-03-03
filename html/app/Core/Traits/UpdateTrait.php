<?php

namespace App\Core\Traits;

use App\Core\Models\BaseModel;
use App\Core\Requests\UpdateRequest;
use Illuminate\Http\JsonResponse;

/**
 * @property ?BaseModel $modelInUse
 * @method BaseModel getModelById(string $id)
 */
trait UpdateTrait
{
    /**
     * @param string $id
     * @param UpdateRequest $request
     * @return JsonResponse
     */
    public function update(string $id, UpdateRequest $request): JsonResponse
    {
        $model = $this->getModelById($id);
        $model->fill($request->validated());
        $model->update();

        $this->modelInUse = $model;

        return response()->json($model);
    }
}
