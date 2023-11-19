<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLessonRequest;
use App\Models\Attendee;
use App\Models\Lesson;
use App\Models\OpenCourse;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function getOpenCoursesTeacher(){
        if(!auth()->user()->hasRole('teacher')){
            throw new \Exception('you are not teacher');
        }
        return  OpenCourse::query()->where('teacherId',auth()->user()->id)
         ->where('finishedAt',null)->with("course")->get();
    }
    public function getLesson($openCourseId){
        $students=OpenCourse::query()->where('id',$openCourseId)->first()->enrollments;

        $lessons= Lesson::query()->where('openCourseId',$openCourseId)
            ->with('attendees')->get();
        return ['lessons'=>$lessons,"students"=>$students];
    }
    public function createLesson(CreateLessonRequest $request){
        $lesson =$request->only([  'openCourseId', 'title',]);
        $studentIds=$request->only(['studentIds'])['studentIds'];
        $lesson['teacherId']=auth()->user()->id;
        $lesson['number']=Lesson::where('openCourseId',$lesson['openCourseId'])->count()+1;
        $lesson=Lesson::create($lesson);
        foreach ($studentIds as $studentId){
            Attendee::create(['lessonId'=>$lesson->id,'studentId'=>$studentId]);
        }

    }
}
