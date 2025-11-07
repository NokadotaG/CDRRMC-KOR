<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $fillable = [
        'location',
        'status',
        'triggered_by',
        'notes',

    ];
}
