<?php

namespace App\Models;

use App\Core\Models\BaseModel;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Card
 * @package App\Models
 *
 * @property int $number
 * @property string $user_id
 * @property string $card_type_id
 * @property DateTime $created_at
 * @property DateTime $updated_at
 * @property DateTime $deleted_at
 * @property Collection|User $user
 * @property Collection|CardType $cardType
 */
class Card extends BaseModel
{
    use SoftDeletes,
        HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'number',
        'user_id',
        'card_type_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function delete(): bool|null
    {
        $this->number = preg_replace("/\w(?=\w{4})/", '9', $this->number);
        $this->save();

        return parent::delete();
    }

    /**
     * @return BelongsTo
     */
    public function cardType(): BelongsTo
    {
        return $this->belongsTo(CardType::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
