<?php

namespace App\Core\Traits;

use App\Core\Models\BaseModel;
use App\Core\Requests\DestroyRequest;
use Illuminate\Http\JsonResponse;

/**
 * @property ?BaseModel $modelInUse
 * @method BaseModel getModelById(string $id)
 */
trait DestroyTrait
{
    /**
     * @param string $id
     * @param DestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(string $id, DestroyRequest $request): JsonResponse
    {
        $model = $this->getModelById($id);
        $model->delete();

        return response()->json($model);
    }
}
