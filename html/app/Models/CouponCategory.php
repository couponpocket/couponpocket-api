<?php

namespace App\Models;

use App\Core\Models\BaseModel;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CouponCategory
 * @package App\Models
 *
 * @property string $name
 * @property string $logo
 * @property string $color_background
 * @property string $color_foreground
 * @property int $code_type
 * @property DateTime $created_at
 * @property DateTime $updated_at
 * @property DateTime $deleted_at
 * @property Collection|Coupon[] $coupons
 */
class CouponCategory extends BaseModel
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'logo',
        'color_background',
        'color_foreground',
        'code_type',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * @return HasMany
     */
    public function coupons(): HasMany
    {
        return $this->hasMany(Coupon::class, 'coupon_category_id');
    }
}
