<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Club extends Model
{
    use HasFactory, SoftDeletes;

    protected static function booted()
    {
        static::updating(function ($club) {
            $user = Auth::user();
            if (!$user || ($user->id !== $club->user_id && !$user->isAdmin())) {
                throw new \Exception('Нет прав для обновления');
            }
        });

        static::deleting(function ($club) {
            $user = Auth::user();
            if (!$user || ($user->id !== $club->user_id && !$user->isAdmin())) {
                throw new \Exception('Нет прав для удаления');
            }
        });
    }

    protected $fillable = [
        'name',
        'country',
        'founded',
        'president',
        'stadium',
        'capacity',
        'trophies',
        'description',
        'image_path',
        'user_id'
    ];

    protected $casts = ['founded' => 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(\App\Models\Comment::class)->orderBy('created_at', 'desc');
    }

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function setFoundedAttribute($value)
    {
        if (!$value) {
            $this->attributes['founded'] = null;
            return;
        }

        if (preg_match('/^\d{4}$/', $value)) {
            $value = "$value-01-01";
        }

        $this->attributes['founded'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function getFoundedAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y') : null;
    }
}
