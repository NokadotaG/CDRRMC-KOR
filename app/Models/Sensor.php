<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    protected $table = "sensor";
    protected $fillable = ([
        'sensor_name',
        'sensor_type',
        'sensor_location',
        'sensor_status',
    ]);
}
