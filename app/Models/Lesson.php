<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'openCourseId',
        'title',
        'number'
    ];

    public function openCourses(){
        return $this->belongsTo(OpenCourse::class, 'openCoursesId', 'id');
    }
    public function attendees(){
        return $this->hasManyThrough(Student::class,Attendee::class,'lessonId','id','id','studentId');

    }


}
