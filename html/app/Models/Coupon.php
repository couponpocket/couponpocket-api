<?php

namespace App\Models;

use App\Core\Models\BaseModel;
use DateTime;
use http\Url;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Date;

/**
 * Class Coupon
 * @package App\Models
 * @property int $id
 * @property string $points
 * @property string $condition
 * @property string $ean
 * @property string $source
 * @property Date $valid_from
 * @property Date $valid_till
 * @property int $coupon_category_id
 * @property DateTime $updated_at
 * @property DateTime $created_at
 * @property DateTime $deleted_at
 * @property Collection|CouponCategory $couponCategory
 * @method static Coupon where(\Closure|string|array $column, $operator = null, $value = null, $boolean = 'and')
 * @method static Coupon select(string $query, array $bindings = [], bool $useReadPdo = true)
 * @method static Coupon whereIn(string $string, array $array_map)
 * @method static Coupon whereNotIn(string $string, array $array_map)

 */
class Coupon extends BaseModel
{
    use SoftDeletes,
        HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'points',
        'condition',
        'ean',
        'source',
        'valid_from',
        'valid_till',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $hidden = [
        'coupon_category_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $dateFormat = 'Y-m-d';

    protected $dates = [
        'valid_from',
        'valid_till'
    ];

    /**
     * @return BelongsTo
     */
    public function couponCategory()
    {
        return $this->belongsTo(CouponCategory::class);
    }
}
