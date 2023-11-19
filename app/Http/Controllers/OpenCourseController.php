<?php

namespace App\Http\Controllers;

use App\Models\OpenCourse;
use Illuminate\Http\Request;

class OpenCourseController extends Controller
{
    public function view($courseId)
    {
        return OpenCourse::where('courseId', $courseId)->with(['teacher','enrollments'])->get();

    }

    public function viewOpenCourses()
    {
        return OpenCourse::query()->with(['teacher','enrollments'])->get();
    }

}
