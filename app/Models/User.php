<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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
     * Check if user is Admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is Dapur (Kitchen)
     */
    public function isDapur(): bool
    {
        return $this->role === 'dapur';
    }

    /**
     * Check if user is Kasir (Cashier)
     */
    public function isKasir(): bool
    {
        return $this->role === 'kasir';
    }

    /**
     * Check if user is Owner
     */
    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }

    /**
     * Check if user has any of the given roles
     */
    public function hasRole(array|string $roles): bool
    {
        if (is_string($roles)) {
            $roles = explode(',', $roles);
        }

        $roles = array_map('trim', $roles);

        return in_array($this->role, $roles);
    }

    /**
     * Get badge label and icon for the role
     */
    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'admin' => 'Administrator',
            'kasir' => 'Kasir',
            'dapur' => 'Dapur',
            'owner' => 'Owner',
            default => ucfirst($this->role ?? 'User'),
        };
    }

    /**
     * Get role badge color class
     */
    public function getRoleBadgeClassAttribute(): string
    {
        return match ($this->role) {
            'admin' => 'badge-danger',
            'kasir' => 'badge-success',
            'dapur' => 'badge-warning',
            'owner' => 'badge-info',
            default => 'badge-secondary',
        };
    }
}
