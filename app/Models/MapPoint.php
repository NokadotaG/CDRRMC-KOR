<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MapPoint extends Model
{
    protected $table = 'map_points';  // Matches your table name
    protected $fillable = [
        'type',  // e.g., 'evacuation' or 'flood'
        'name',
        'description',
        'address',  // Nullable as per your schema
        'latitude',
        'longitude',
    ];

    protected $cast = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];
}
