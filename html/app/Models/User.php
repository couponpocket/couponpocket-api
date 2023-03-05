<?php

namespace App\Models;

use App\Core\Models\BaseModel;
use App\Notifications\VerifyEmail;
use DateTime;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailConstant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Traits\ForwardsCalls;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * Class User
 * @package App\Models
 *
 * @property-read string $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property int $role
 * @property string $remember_token
 * @property bool $isVerified
 * @property DateTime $email_verified_at
 * @property DateTime $created_at
 * @property DateTime $updated_at
 * @property DateTime $deleted_at
 */
class User extends BaseModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    MustVerifyEmailConstant
{
    use HasFactory,
        HasApiTokens,
        Authenticatable,
        Authorizable,
        CanResetPassword,
        MustVerifyEmail,
        SoftDeletes,
        Notifiable,
        ForwardsCalls;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'updated_at',
        'created_at',
        'deleted_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    public function getIsVerifiedAttribute(): bool
    {
        return $this->hasVerifiedEmail();
    }

    public function isAdmin(): bool
    {
        return $this->role === 1;
    }

    public function isModerator(): bool
    {
        return $this->role === 2;
    }

    public function isPartner(): bool
    {
        return $this->role === 3;
    }

    public function isUser(): bool
    {
        return $this->role === 4;
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmail);
    }

    public function getEmailValidationCode(): string
    {
        return mb_strtoupper(substr(sha1($this->id . $this->email . config('app.key') . (time() - (time() % 900))), 0, 6));
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function tokens(): MorphMany
    {
        return $this->morphMany(PersonalAccessToken::class, 'tokenable');
    }
}
