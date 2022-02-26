<?php

namespace App\Core\Traits;

use App\Core\Models\BaseModel;
use App\Http\Requests\IndexPaginationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @property BaseModel|string $modelClass
 */
trait IndexPaginationTrait
{
    /**
     * @param IndexPaginationRequest $request
     * @return JsonResponse
     */
    public function index(IndexPaginationRequest $request): JsonResponse
    {
        $perPage = $request->input('perPage', 15);
        $sortKey = $request->input('sortKey', $this->getDefaultSortKey());
        $orderBy = $request->input('sortOrder', 'asc');

        return response()->json($this->modelClass::orderBy($sortKey, $orderBy)
            ->paginate($perPage));
    }

    /**
     * @return string
     */
    protected function getDefaultSortKey(): string
    {
        return 'updated_at';
    }
}
