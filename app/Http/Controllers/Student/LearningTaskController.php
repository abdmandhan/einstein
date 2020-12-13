<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CourseTask;
use App\Models\CourseTaskQuestion;
use App\Models\CourseTaskStudent;
use App\Models\CourseTaskStudentAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LearningTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $answer = (object) $request->input('answer');
        $task = (object) $request->input('task');

        foreach ($answer as $key => $value) {
            if (is_integer($value)) {
                $data = [
                    'user_id'       => Auth::id(),
                    'task_id'       => $task->id,
                    'question_id'   => $key,
                    'answer_id'     => $value,
                ];
            } else {
                $data = [
                    'user_id'       => Auth::id(),
                    'task_id'       => $task->id,
                    'question_id'   => $key,
                    'answer_essay'  => $value,
                ];
            }

            CourseTaskStudentAnswer::updateOrCreate([
                'user_id'       => Auth::id(),
                'task_id'       => $task->id,
                'question_id'   => $key,
            ], $data);
        }

        $course_task_student = CourseTaskStudent::where('user_id', Auth::id())->where('course_task_id', $task->id);
        $course_task_student->update([
            'finish_date'   => now()
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
        $course_task = CourseTask::with(['course_task_question.course_task_answer'])->find($id);

        return $this->success($course_task);
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
