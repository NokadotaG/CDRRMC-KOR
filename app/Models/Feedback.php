<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    public $table = 'feedbacks';

    protected $fillable = ['task_id', 'responder_id', 'rating', 'comments'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function responder()
    {
        return $this->belongsTo(Responder::class);
    }
}
