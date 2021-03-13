<?php

namespace App\Models;

use App\Core\Models\BaseModel;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Coupon
 * @package App\Models
 * @property int $id
 * @property string $where
 * @property string $points
 * @property string $condition
 * @property string $ean
 * @property string $source
 * @property DateTime $valid_from
 * @property DateTime $valid_till
 * @property DateTime $updated_at
 * @property DateTime $created_at
 * @property DateTime $deleted_at
 */
class Coupon extends BaseModel
{
    use SoftDeletes,
        HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'where',
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
        'id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $dates = [
        'valid_from',
        'valid_till'
    ];
}
