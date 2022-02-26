<?php

namespace App\Core\Models;

use Illuminate\Support\Str;

class UUIDModel extends BaseModel
{
    public $incrementing = false;
    public $keyType = 'string';

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            /** @var BaseModel $model */
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string)Str::uuid();
            }
        });
    }
}
