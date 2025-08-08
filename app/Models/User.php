<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

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
        'role_id', // Add role_id here
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
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    /**
     * Check if the user has a specific role.
     *
     * @param string $roleName The role name to check (e.g., 'admin', 'employee').
     * @return bool
     */
    public function hasRole(string $roleName): bool
    {
        // Map role names to their corresponding IDs for robust checking.
        $roleMap = [
            'admin' => 1,
            'employee' => 2,
        ];

        $normalizedRoleName = strtolower($roleName);

        // Check if the provided role name exists in our map.
        if (!isset($roleMap[$normalizedRoleName])) {
            return false;
        }

        // Compare the user's role_id with the ID from the map.
        return $this->role_id === $roleMap[$normalizedRoleName];
    }


    /**
     * Get the role that the user belongs to.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * The departments that the user belongs to.
     */
    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class);
    }
}
