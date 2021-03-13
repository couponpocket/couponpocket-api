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
 * @property int $id
 * @property string $name
 * @property string $logo
 * @property string $color
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
        'color',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * @param $value
     */
    public function setLogoAttribute($value)
    {
        $this->attributes['logo'] = basename($value);
    }

    /**
     * @return string
     */
    public function getLogoAttribute()
    {
        return url('/images/logos/'.$this->attributes['logo']);
    }

    /**
     * @return HasMany
     */
    public function coupons()
    {
        return $this->hasMany(Coupon::class, 'coupon_category_id');
    }
}
