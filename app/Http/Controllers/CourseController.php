<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->success([
            'data'          => Course::all([
                'id',
                'course_type_id',
                'name',
                'desc',
                'is_premium',
                'price',
                'grade_id',
                'created_at'
            ])->append([
                'course_type_name',
                'grade_name'
            ]),
            'header'        => [
                [
                    'text'  => 'ID',
                    'value' => 'id'
                ],
                [
                    'text'  => 'Name',
                    'value' => 'name'
                ],
                [
                    'text'  => 'Description',
                    'value' => 'desc'
                ],
                [
                    'text'  => 'Course Type',
                    'value' => 'course_type_name'
                ],
                [
                    'text'  => 'Premium',
                    'value' => 'is_premium'
                ],
                [
                    'text'  => 'Price',
                    'value' => 'price'
                ],
                [
                    'text'  => 'Grade',
                    'value' => 'grade_name'
                ],
                [
                    'text'  => 'Actions',
                    'value' => 'actions'
                ],

            ],
            'relation_key'   => 'course_id',
            'api'           => [
                'course_content'    => route('course-content.index'),
                'course_task'       => route('course-task.index'),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return $this->success([
            'relation_key'   => 'course_id',
            'api'           => [
                'course_content'    => route('course-content.index'),
                'course_task'       => route('course-task.index'),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'              => 'required',
            'desc'              => 'required',
            'course_type_id'    => 'required',
            'is_premium'        => 'required',
            'price'             => [Rule::requiredIf($request->input('is_premium')), 'nullable', 'numeric'],
            'grade_id'          => 'required'
        ]);

        $course = Course::create($data);

        return $this->success($course);
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course = Course::with([
            'course_content',
            'course_task'
        ])->findOrFail($id);

        return $this->success([
            'course'    => $course,
            'relation_key'   => 'course_id',
            'api'           => [
                'course_content'    => route('course-content.index'),
                'course_task'       => route('course-task.index'),
            ]
        ]);
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
        Course::find($id)->delete();

        return $this->success();
    }
}
