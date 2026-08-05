<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = [
        'geo_code',
        'code',
        'name',
        'short_name',
        'population',
        'female_population',
        'male_population',
        'inhabited_homes',
    ];

    protected $casts = [
        'population' => 'integer',
        'female_population' => 'integer',
        'male_population' => 'integer',
        'inhabited_homes' => 'integer',
    ];
}
