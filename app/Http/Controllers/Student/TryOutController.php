<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\TryOut;
use Illuminate\Http\Request;
use App\Models\TryOutStudent;
use App\Models\TryOutStudentAnswer;
use Illuminate\Support\Facades\Auth;

class TryOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = TryOut::with(['difficulty'])->get()->append(['student_assign']);
        return $this->success(
            $data
        );
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
        $data = (object) $request->input();
        $try_out_student = TryOutStudent::where('user_id', Auth::id())->where('try_out_id', $data->id)->first();
        if (!$try_out_student) {
            TryOutStudent::create([
                'user_id'       => Auth::id(),
                'try_out_id'    => $data->id,
                'start_date'    => now(),
            ]);
        }

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
        //
        $data = TryOut::with([
            'try_out_question.try_out_answer'
        ])->find($id);

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
        $answer = (object) $request->input('answer');
        $tryout = (object) $request->input('tryout');

        foreach ($answer as $key => $value) {
            if (is_integer($value)) {
                $data = [
                    'user_id'       => Auth::id(),
                    'try_out_id'       => $tryout->id,
                    'question_id'   => $key,
                    'answer_id'     => $value,
                ];
            } else {
                $data = [
                    'user_id'       => Auth::id(),
                    'try_out_id'       => $tryout->id,
                    'question_id'   => $key,
                    'answer_essay'  => $value,
                ];
            }

            TryOutStudentAnswer::updateOrCreate([
                'user_id'       => Auth::id(),
                'try_out_id'       => $tryout->id,
                'question_id'   => $key,
            ], $data);
        }

        $course_task_student = TryOutStudent::where('user_id', Auth::id())->where('try_out_id', $tryout->id);
        $course_task_student->update([
            'finish_date'   => now()
        ]);

        return $this->success();
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
