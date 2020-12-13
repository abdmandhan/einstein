<?php

namespace App\Http\Controllers;

use App\Models\CourseStudent;
use App\Models\CourseTaskStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LearningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = CourseStudent::with([
            'course.course_type',
            'course.grade',
        ])->where('user_id', Auth::id())->get();

        if (count($data) == 0) return $this->failed();
        return $this->success($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = (object)$request->input();

        $course_task_student = CourseTaskStudent::find($data->id);
        $course_task_student->update([
            'start_date'    => now()
        ]);

        return $this->success();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = CourseStudent::with([
            'course.course_type',
            'course.course_content',
            'course.course_task_student.course_task.difficulty',
            'course.course_task_student.course_task.course_task_student_answer.question',
            'course.course_task_student.course_task.course_task_student_answer.answer'
        ])->findOrFail($id);

        return $this->success($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
