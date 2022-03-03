<?php

namespace App\Core\Traits;

use App\Core\Models\BaseModel;
use App\Core\Requests\ShowRequest;
use Illuminate\Http\JsonResponse;

/**
 * @method BaseModel getModelById(string $id)
 */
trait ShowTrait
{
    /**
     * @param string $id
     * @param ShowRequest $request
     * @return JsonResponse
     */
    public function show(string $id, ShowRequest $request): JsonResponse
    {
        return response()->json($this->getModelById($id));
    }
}
