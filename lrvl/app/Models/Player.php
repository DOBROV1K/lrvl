<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'name',
        'position',
        'number',
        'nationality',
        'age',
        'club_id'
    ];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}
