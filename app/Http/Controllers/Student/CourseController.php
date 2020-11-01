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
        $course = Course::find($request->input('course_id'));

        if ($course->is_premium) {
            $data = $request->validate([
                'course_id'     => ['required'],
                'image'         => ['required'],
                'account_name'  => ['required'],
                'account_no'    => ['required']
            ]);
        } else {
            $data = $request->validate([
                'course_id'     => ['required'],
                'image'         => ['nullable', 'mimes:jpeg,jpg,png,gif', 'max:100000'],
                'account_name'  => ['string', 'nullable'],
                'account_no'    => ['string', 'nullable']
            ]);
        }


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
