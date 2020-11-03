<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseStudent;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    //
    public function index()
    {
        return $this->success([
            'data'      => Course::with(['course_type', 'grade', 'course_teacher.teacher'])->get()
        ]);
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage. ||| BUY COURSE
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $course = Course::where('id', $request->input('course_id'))->first();

        de([$course, $request->post('course_id'), $request->all()]);

        if ($course->is_premium) {
            $data = (object) $request->validate([
                'course_id'     => ['required'],
                'image'         => ['required'],
                'account_name'  => ['required'],
                'account_no'    => ['required']
            ]);
        } else {
            $data = (object) $request->validate([
                'course_id'     => ['required'],
            ]);
        }

        de((Course::find($data->course_id))->price);

        CourseStudent::create([
            'user_id'       => Auth::id(),
            'course_id'     => $data->course_id,
        ]);

        Transaction::create([
            'user_id'               => Auth::id(),
            'course_id'             => $data->course_id,
            'transaction_status_id' => 1,
            'transaction_date'      => now(),
            'amount'                => Course::find($data->course_id)->price
        ]);


        de($data);
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
        return $this->success([
            'data'  => Course::with(['course_type', 'grade', 'course_teacher.teacher', 'course_content'])->find($id)
        ]);
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
    public function update(Request $request)
    {
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
