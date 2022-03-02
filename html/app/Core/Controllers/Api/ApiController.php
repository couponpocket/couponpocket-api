<?php

namespace App\Core\Controllers\Api;

use App\Core\Models\BaseModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class ApiController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected ?BaseModel $modelInUse = null;

    /**
     * define which main model this Controller is using
     *
     * @noinspection PhpDocFieldTypeMismatchInspection
     * @var string|BaseModel $modelClass
     */
    protected string $modelClass;

    /**
     * @return BaseModel
     */
    protected function createModelFromClass(): BaseModel
    {
        return new $this->modelClass;
    }

    /**
     * @param int $id
     * @return BaseModel
     */
    protected function getModelById(int $id): BaseModel
    {
        return $this->modelClass::findOrFail($id);
    }
}
