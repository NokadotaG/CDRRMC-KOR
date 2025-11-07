<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Responder extends Model
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'res_fname',
        'res_mname',
        'res_lname',
        'res_suffix',
        'res_username',
        'res_email',
        'res_password',
        'res_contact',
        'res_position',
        'res_company',
        'res_workadd',
        'res_image',
    ];

    protected $hidden =[
        'res_password',
        'remember_token',
    ];

    public function casts(): array{
        return[
            'email_verfied_at' => 'datetime',
            'res_password' => 'hashed',
        ];
    }
}
