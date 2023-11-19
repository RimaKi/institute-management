<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable=[
        "id",
        "title",
        "description",
        "level",
        "hours"

    ];

    public function openCourses(){
        $this->hasMany(OpenCourse::class,'courseId','id');
    }
}
