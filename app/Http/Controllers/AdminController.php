<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCourseRequest;
use App\Http\Requests\CreateOpenCourseRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Jobs\SendEmailPasswordQueueJob;
use App\Models\Course;
use App\Models\OpenCourse;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    //users
    public function createUser(CreateUserRequest $request)
    {
        $data = $request->only(["name", "phone", "email", "role"]);
        $password = Str::random(6);
        $data["password"] = Hash::make($password);
        $user = User::create($data);
        $role = Role::findByName($data['role']);
        $user->assignRole($role);
        $send = ['to' => $data['email'], 'password' => $password];
        dispatch(new SendEmailPasswordQueueJob($send));

    }

    public function viewUsers()
    {
        $roles = Role::all();
        $users = [];
        foreach ($roles as $role) {
            $users[$role->name] = $role->users;
        }
        return $users;
    }

    public function login(LoginRequest $loginRequest)
    {
        $data = $loginRequest->only(["email", "password"]);
        if (!Auth::attempt($data)) {
            throw new \Exception("wrong email or password");
        }
        return array_merge(\auth()->user()->toArray(),
            ['role' => \auth()->user()->roles->first()->name,
                'token' => \auth()->user()->createToken($loginRequest->ip())->plainTextToken]);
    }

    public function updateUser(UpdateUserRequest $request, $id)
    {
        User::find($id)->update($request->all());
    }

    //courses
    public function createCourse(CreateCourseRequest $request)
    {
        $data = $request->only(["title", "description", "level", "hours"]);
        $course = Course::query();
        foreach ($data as $i => $v) {
            $course->where($i, $v);
        }
        if ($course->first() != null) {
            throw new \Exception("already exist");
        }
        Course::create($data);
    }

    public function viewCourses()
    {
        return Course::all();
    }

    public function createOpenCourse(CreateOpenCourseRequest $request)
    {
        $data = $request->only(['id', 'courseId', 'teacherId', 'startDate', 'finishedAt', 'cost']);
        OpenCourse::create($data);
    }

    public function endingOpenCourse(OpenCourse $openCourseId)
    {
        $openCourseId->update(['finishedAt' => Carbon::now()]);
    }

    public function logout()
    {
        \auth()->user()->tokens()->delete();
    }

}

