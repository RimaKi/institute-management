<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddStudentRequest;
use App\Http\Requests\SearchStudentRequest;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function search(SearchStudentRequest $request)
    {
        $data = $request->only('search');
        return $this->filter(Student::query(), ['firstName', 'phone'], $data['search']);
    }
    public function add(AddStudentRequest $request){
        $data = $request->only(["firstName", "lastName", "middleName", "phone", "email"]);
        Student::create($data);
    }
    public function view($openCourseId){
        return Student::query()->with('openCourses',function ($q)use ($openCourseId){
            $q->where('openCourseId','=',(int)$openCourseId);
        })->get();
    }
}
