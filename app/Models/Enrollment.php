<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'openCourseId',
        'studentId',
        'paidAt'
    ];

    public function openCourses(){
        return $this->belongsTo(OpenCourse::class, 'openCourseId', 'id');
    }
    public function student(){
        return $this->belongsTo(Student::class, 'studentId', 'id');
    }
}
