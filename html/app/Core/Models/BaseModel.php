<?php

namespace App\Core\Models;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property-read string $id
 * @method static self create(array $array)
 * @method static self|null find(int $id)
 * @method static self findOrFail(int $id, array $columns = ['*'])
 * @method static Builder where(\Closure|string|array $column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder select(string $query, array $bindings = [], bool $useReadPdo = true)
 * @method static Builder whereIn(string $string, array $array_map)
 * @method static Builder whereNotIn(string $string, array $array_map)
 * @method static count(string $column = '*')
 * @method static Builder orderBy($column, $direction = 'asc')
 * @method static Builder|static whereHas($relation, Closure $callback = null, $operator = '>=', $count = 1)
 * @method Builder|static orWhere(\Closure|array|string $column, $operator = null, $value = null)
 * @method self fill(array $attributes)
 * @method bool|null delete()
*/
abstract class BaseModel extends Model
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
