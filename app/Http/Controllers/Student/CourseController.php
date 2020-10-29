<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    //
    public function index()
    {
        return $this->success([
            'data'      => Course::with(['course_type', 'grade', 'course_teacher.teacher'])->get()
        ]);
    }
}
