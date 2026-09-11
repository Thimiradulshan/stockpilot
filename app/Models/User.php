<?php

namespace App\Models;

use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $profile_photo_path
 * @property string $role
 * @property string $status
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property Carbon|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['name', 'email', 'password', 'profile_photo_path'])]
#[Hidden([
    'password',
    'two_factor_secret',
    'two_factor_recovery_codes',
    'remember_token',
])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Return the user's role as a validated enum.
     *
     * Invalid stored values return null instead of throwing.
     */
    public function roleEnum(): ?UserRole
    {
        $role = $this->getRawOriginal('role');

        if ($role instanceof UserRole) {
            return $role;
        }

        if (! is_string($role)) {
            return null;
        }

        return UserRole::tryFrom($role);
    }

    /**
     * Get purchases created by this user.
     */
    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'created_by');
    }

    /**
     * Get invoices created by this user.
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'created_by');
    }

    /**
     * Get payments received by this user.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'received_by');
    }

    /**
     * Get stock movements created by this user.
     */
    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class, 'created_by');
    }

    /**
     * Determine whether the user is an administrator.
     */
    public function isAdmin(): bool
    {
        return $this->roleEnum() === UserRole::ADMIN;
    }

    /**
     * Determine whether the user is a sales user.
     */
    public function isSalesUser(): bool
    {
        return $this->roleEnum() === UserRole::SALES;
    }

    /**
     * Determine whether the user is a stock user.
     */
    public function isStockUser(): bool
    {
        return $this->roleEnum() === UserRole::STOCK;
    }

    /**
     * Determine whether the user account is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Get the user's initials.
     */
    public function initials(): string
    {
        $initials = Str::initials($this->name, true);

        return Str::length($initials) > 1
            ? Str::substr($initials, 0, 1).Str::substr($initials, -1)
            : $initials;
    }

    /**
     * Determine whether the user has a profile photo.
     */
    public function hasProfilePhoto(): bool
    {
        return is_string($this->profile_photo_path)
            && $this->profile_photo_path !== '';
    }

    /**
     * Get the public URL for the user's profile photo.
     */
    public function profilePhotoUrl(): ?string
    {
        if (! $this->hasProfilePhoto()) {
            return null;
        }

        return Storage::disk('public')->url($this->profile_photo_path);
    }
}
