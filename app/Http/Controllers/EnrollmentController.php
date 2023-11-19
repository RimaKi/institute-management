<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddEnrollmentRequest;
use App\Http\Requests\FilterEnrollmentRequest;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function create(AddEnrollmentRequest $request)
    {
        $data = $request->only(['openCourseId', 'studentId', 'paidAt']);
        Enrollment::create($data);
    }


    public function paidEnrollment(FilterEnrollmentRequest $request)
    {
        $data = $request->only(['startDate', 'endDate']);
        $filter = Enrollment::query()->where('paidAt', '<>', null);
        if (array_key_exists('startDate', $data)) {
            $filter = $filter->whereDate('paidAt', '>=', $data['startDate']);
        }
        if (array_key_exists('endDate', $data)) {
            $filter = $filter->whereDate('paidAt', '<=', $data['endDate']);
        }
        return $filter->with(['openCourse.course','student'])->get();
    }

    public function unpaidEnrollment()
    {
        return Enrollment::query()->where('paidAt', null)
                ->with(['openCourse.course','student'])->get();
    }



}
