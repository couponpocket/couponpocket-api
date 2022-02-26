<?php

namespace App\Core\Controllers;

use App\Core\Models\BaseModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @noinspection PhpDocFieldTypeMismatchInspection
     * @var string|BaseModel $modelClass
     */
    protected string $modelClass;

    protected ?BaseModel $modelInUse = null;

    /**
     * @return BaseModel
     */
    protected function createModelFromClass(): BaseModel
    {
        return new $this->modelClass;
    }

    /**
     * @param string $id
     * @return BaseModel
     */
    protected function getModelById(string $id): BaseModel
    {
        return $this->modelClass::findOrFail($id);
    }
}
