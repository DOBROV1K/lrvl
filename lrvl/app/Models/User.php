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
        'is_admin',
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
            'is_admin' => 'boolean',
        ];
    }
    
    public function clubs()
    {
        return $this->hasMany(Club::class);
    }

    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')->withTimestamps();
    }

    public function friendedBy()
    {
        return $this->belongsToMany(User::class, 'friends', 'friend_id', 'user_id')->withTimestamps();
    }

    public function isFriendWith(User $user): bool
    {
        if (!$user->id) return false;
        return $this->friends()->where('friend_id', $user->id)->exists();
    }

    public function addFriend(User $user)
    {
        if ($this->id === $user->id) return false;
        if (!$this->isFriendWith($user)) {
            $this->friends()->attach($user->id);
            return true;
        }
        return false;
    }

    public function removeFriend(User $user)
    {
        if ($this->isFriendWith($user)) {
            $this->friends()->detach($user->id);
            return true;
        }
        return false;
    }

}
