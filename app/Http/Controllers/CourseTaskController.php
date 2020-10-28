<?php

namespace App\Http\Controllers;

use App\Models\CourseTask;
use Illuminate\Http\Request;

class CourseTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return $this->success([
            'data'      => [],
            'header'    => [
                [
                    'text'  => 'ID',
                    'value' => 'id',
                    'disabled'  => true,
                ],
                [
                    'text'  => 'Name',
                    'value' => 'name'
                ],
                [
                    'text'  => 'Difficulty',
                    'value' => 'difficulty_id'
                ],
                [
                    'text'  => 'Time',
                    'value' => 'time'
                ],

                [
                    'text'  => 'Actions',
                    'value' => 'actions'
                ],

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
        //
        $data = $request->validate([
            'id'            => 'nullable',
            'course_id'     => 'required',
            'name'          => 'required',
            'difficulty_id' => 'required',
            'time'          => 'required',
        ]);

        if (isset($data['id'])) {
            CourseTask::find($data['id'])->update($data);
        } else {
            CourseTask::create($data);
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
        return $this->success([
            'data'      => CourseTask::where('course_id', $id)->get([
                'id',
                'name',
                'course_id',
                'difficulty_id',
                'time',
            ]),
            'header'    => [
                [
                    'text'  => 'ID',
                    'value' => 'id',
                    'disabled'  => true,
                ],
                [
                    'text'  => 'Name',
                    'value' => 'name'
                ],
                [
                    'text'  => 'Difficulty',
                    'value' => 'difficulty_id'
                ],
                [
                    'text'  => 'Time',
                    'value' => 'time'
                ],

                [
                    'text'  => 'Actions',
                    'value' => 'actions'
                ],

            ]
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
        CourseTask::find($id)->delete();

        return $this->success();
    }
}
