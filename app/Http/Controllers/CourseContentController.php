<?php

namespace App\Http\Controllers;

use App\Models\CourseContent;
use Illuminate\Http\Request;

class CourseContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
            'id'                => 'nullable',
            'course_id' => 'required',
            'name'      => 'required',
            'desc'      => 'required',
            'content'   => 'required',
            'file'      => 'required',
            'image'     => 'required'
        ]);

        if (isset($data['id'])) {
            CourseContent::find($data['id'])->update($data);
        } else {
            unset($data['id']);
            CourseContent::create($data);
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
            'data'      => CourseContent::where('course_id', $id)->get([
                'id',
                'course_id',
                'name',
                'desc',
                'content',
                'file',
                'image'
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
        CourseContent::find($id)->delete();

        return $this->success();
    }
}
