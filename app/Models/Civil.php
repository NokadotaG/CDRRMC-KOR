<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Civil extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'civil'; // Custom table name
    protected $fillable = [
        'username',
        'image',
        'firstname',
        'middlename',
        'lastname',
        'suffix',
        'birthday',
        'gender',
        'street_purok',
        'baranggay',
        'email',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthday' => 'date',
    ];
}
