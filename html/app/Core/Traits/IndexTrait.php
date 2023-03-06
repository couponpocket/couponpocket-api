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
        $sortKey = $request->input('sortKey', $this->getDefaultSortKey());
        $sortOrder = $request->input('sortOrder', 'asc');

        return response()->json($this->modelClass::orderBy($sortKey, $sortOrder)->get());
    }

    /**
     * @return string
     */
    protected function getDefaultSortKey(): string
    {
        return 'updated_at';
    }
}
