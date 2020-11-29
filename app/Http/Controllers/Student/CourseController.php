<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseStudent;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    //
    public function index()
    {
        $ownedCourse = Auth::user()->course()->pluck('course_id');
        return $this->success([
            'data'      => Course::whereNotIn('id', $ownedCourse)->with(['course_type', 'grade', 'course_teacher.teacher'])->get()
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
        $course = Course::where('id', $request->input('course_id'))->firstOrFail();

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

        $path = null;

        if ($request->file('image')) {
            $path = 'storage/' . $request->file('image')->store('transaction', 'public');
        }

        DB::transaction(function () use ($data, $path, $course) {
            if (!$course->is_premium) {
                CourseStudent::create([
                    'user_id'       => Auth::id(),
                    'course_id'     => $data->course_id,
                ]);
            }

            Transaction::create([
                'user_id'               => Auth::id(),
                'course_id'             => $data->course_id,
                'transaction_status_id' => $course->is_premium ? 1 : 2,
                'transaction_date'      => now(),
                'amount'                => Course::find($data->course_id)->price ?? null,
                'image'                 => $path,
                'account_no'            => $data->account_no ?? null,
                'account_name'          => $data->account_name ?? null,
            ]);
        });


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

    public function payment($id)
    {
        $transaction = Transaction::where('user_id', Auth::id())->where('id', $id)->with(['course'])->firstOrFail();

        return $this->success($transaction);
    }
}
