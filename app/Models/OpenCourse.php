<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenCourse extends Model
{
    use HasFactory;
    protected $table='open__courses';
    protected $fillable=[
        'id',
        'courseId',
        'teacherId',
        'startDate',
        'finishedAt',
        'cost'
    ];
    protected $appends=[
        'numberOfStudent'
    ];

    public function course(){
        return $this->belongsTo(Course::class,'courseId','id');
    }

    public function teacher(){
        return $this->belongsTo(User::class,'teacherId','id');
    }
    public function enrollments(){
        return $this->hasManyThrough(Student::class,Enrollment::class,'openCourseId','id','id','studentId');
    }
    public function getNumberOfStudentAttribute(){
        return $this->enrollments()->count();
    }
}
