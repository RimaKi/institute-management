<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddPaymentRequest;
use App\Mail\SendEmailToStudent;
use App\Models\Enrollment;
use App\Models\OpenCourse;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class AccountantController extends Controller
{
    public function getStudents(){
        return Student::query()->with('openCourses',function ($q){
            $q->where('finishedAt','=',null);
        })->get();
    }
    public function addPayment(AddPaymentRequest $request){
        $data= $request->only(['studentId','openCourseId']);
        Enrollment::query()->where($data)->first()->update(['paidAt'=>Carbon::now()]);
        $openCourse=OpenCourse::find($data['openCourseId']);
//        $send=['to'=>Student::find($data['studentId'])->email,
//               'course'=>['name'=>$openCourse->course->title,
//                          'startAt'=>$openCourse->startAt]];
//        dispatch(new SendEmailToStudentJob($send));
        Mail::to(Student::find($data['studentId'])->email)->send(new SendEmailToStudent(
            ['name'=>$openCourse->course->title,'startAt'=>$openCourse->startDate]));


    }
}
