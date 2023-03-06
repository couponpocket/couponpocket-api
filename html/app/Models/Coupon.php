<?php

namespace App\Models;

use App\Core\Models\BaseModel;
use DateTime;
use http\Url;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Coupon
 * @package App\Models
 *
 * @property string $points
 * @property string $condition
 * @property string $ean
 * @property string $source
 * @property DateTime $valid_from
 * @property DateTime $valid_till
 * @property int $coupon_category_id
 * @property DateTime $updated_at
 * @property DateTime $created_at
 * @property DateTime $deleted_at
 * @property Collection|CouponCategory $couponCategory
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
    public function couponCategory(): BelongsTo
    {
        return $this->belongsTo(CouponCategory::class);
    }
}
