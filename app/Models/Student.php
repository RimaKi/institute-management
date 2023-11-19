<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable=[
        "id",
        "firstName",
        "lastName",
        "middleName",
        "phone",
        "email",
    ];

    public function attendees(){
       return $this->hasMany(Attendee::class,'studentId','id');
    }
    public function openCourses(){
        return $this->hasManyThrough(OpenCourse::class,Enrollment::class,'studentId','id','id','openCourseId');

    }
}
