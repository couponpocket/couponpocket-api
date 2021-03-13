<?php

namespace App\Core\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
* @property int $id
* @method static Model create(array $array)
* @method static Model|null find(int $id)
* @method static Model findOrFail(int $id, array $columns = ['*'])
* @method static Builder where(\Closure|string|array $column, $operator = null, $value = null, $boolean = 'and')
* @method static Builder select(string $query, array $bindings = [], bool $useReadPdo = true)
* @method static whereIn(string $string, array $array_map)
* @method static count(string $column = '*')
* @method Builder|static orWhere(\Closure|array|string $column, $operator = null, $value = null)
* @method Model fill(array $attributes)
* @method bool|null delete()
*/
abstract class BaseModel extends Model
{
}
