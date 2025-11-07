<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = "task";
    protected $fillable =[
        'title',
        'description',
        'location',
        'status',
        'responder_id',
        'due_datetime',
    ];

    protected $casts = [
        'due_datetime' => 'datetime',
    ];

    public function responder(){
        return $this->belongsTo(Responder::class, 'responder_id', 'id');
    }
}
