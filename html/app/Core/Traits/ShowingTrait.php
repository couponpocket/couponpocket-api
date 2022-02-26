<?php

namespace App\Core\Traits;

use App\Core\Models\BaseModel;
use Illuminate\Http\JsonResponse;

/**
 * @method BaseModel getModelById(string $id)
 */
trait ShowingTrait
{
    /**
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        return response()->json($this->getModelById($id));
    }
}
