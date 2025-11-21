<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Club extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'clubs';

    protected $fillable = [
        'name',
        'country',
        'founded',
        'president',
        'stadium',
        'capacity',
        'trophies',
        'description',
        'image_path'
    ];

    protected $casts = [
        'founded' => 'date',
    ];

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
        if (!$value) return null;
        return Carbon::parse($value)->format('Y');
    }
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst(strtolower(trim($value)));
    }

    
    public function setCountryAttribute($value)
    {
        $this->attributes['country'] = strtoupper(trim($value));
    }

    
    public function setPresidentAttribute($value)
    {
        $this->attributes['president'] = ucfirst(strtolower(trim($value)));
    }

}
