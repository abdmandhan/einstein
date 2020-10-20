<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

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
            'data'      => Course::with([
                'course_content',
                'course_task'
            ])->get([
                'id',
                'course_type_id',
                'name',
                'is_premium',
                'price',
                'grade_id',
                'created_at'
            ])->append([
                'course_type_name',
                'grade_name'
            ]),
            'header'    => [
                'course'    => [
                    [
                        'text'  => 'ID',
                        'value' => 'id'
                    ],
                    [
                        'text'  => 'Name',
                        'value' => 'name'
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
                'course_content'    => [
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
                        'text'  => 'Content',
                        'value' => 'content'
                    ],
                    [
                        'text'  => 'File',
                        'value' => 'file'
                    ],
                    [
                        'text'  => 'Image',
                        'value' => 'image'
                    ],

                    [
                        'text'  => 'Actions',
                        'value' => 'actions'
                    ],
                ],
                'course_task'    => [
                    [
                        'text'  => 'ID',
                        'value' => 'id'
                    ],
                    [
                        'text'  => 'Name',
                        'value' => 'name'
                    ],
                    [
                        'text'  => 'Actions',
                        'value' => 'actions'
                    ],
                ]

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
            'id'                => 'nullable',
            'name'              => 'required',
            'course_type_id'    => 'required',
            'is_premium'        => 'required',
            'price'             => ['nullable', 'numeric'],
            'grade_id'          => 'required'
        ]);

        if (isset($data['id'])) {
            Course::find($data['id'])->update($data);
        } else {
            Course::create($data);
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
        Course::find($id)->delete();

        return $this->success();
    }
}
