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

    // Мутатор: позволяющий вводить только год (YYYY)
    public function setFoundedAttribute($value)
    {
        if (!$value) {
            $this->attributes['founded'] = null;
            return;
        }

        // если введён только год
        if (preg_match('/^\d{4}$/', $value)) {
            $value = "$value-01-01";
        }

        $this->attributes['founded'] = Carbon::parse($value)->format('Y-m-d');
    }

    // Преобразовываем дату в выводе
    public function getFoundedAttribute($value)
    {
        if (!$value) return null;
        return Carbon::parse($value)->format('Y');
    }
    // Имя клуба: первая буква заглавная
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst(strtolower(trim($value)));
    }

    // Страна: всегда заглавными
    public function setCountryAttribute($value)
    {
        $this->attributes['country'] = strtoupper(trim($value));
    }

    // Президент: первая буква заглавная
    public function setPresidentAttribute($value)
    {
        $this->attributes['president'] = ucfirst(strtolower(trim($value)));
    }

}
