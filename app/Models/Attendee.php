<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'lessonId',
        'studentId'
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lessonId', 'id');
    }

    public function student(){
        return $this->belongsTo(Student::class, 'studentId', 'id');
    }
}
