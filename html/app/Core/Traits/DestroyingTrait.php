<?php

namespace App\Core\Traits;

use App\Core\Models\BaseModel;
use Illuminate\Http\JsonResponse;

/**
 * @property ?BaseModel $modelInUse
 * @method BaseModel getModelById(string $id)
 */
trait DestroyingTrait
{
    /**
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $model = $this->getModelById($id);
        $model->delete();

        return response()->json($model);
    }
}
