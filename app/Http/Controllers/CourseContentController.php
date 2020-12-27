<?php

namespace App\Http\Controllers;

use App\Models\CourseContent;
use App\Rules\Youtube;
use Illuminate\Http\Request;

class CourseContentController extends Controller
{
    public $headers = [
        [
            'text'  => 'ID',
            'value' => 'id',
            'disabled'  => true,
            'component' => 'v-text-field',
        ],
        [
            'text'  => 'Name',
            'value' => 'name',
            'component' => 'v-text-field',
        ],
        [
            'text'  => 'Description',
            'value' => 'desc',
            'component' => 'v-textarea',
        ],
        [
            'text'  => 'Content',
            'value' => 'content',
            'component' => 'v-textarea',
        ],
        [
            'text'  => 'File',
            'value' => 'file',
            'component' => 'v-file-input',
            'slot'  => 'item.file',
            'type'  => 'file',
        ],
        [
            'text'  => 'Url Youtube',
            'value' => 'url_youtube',
            'component' => 'v-text-field',
            'slot'  => 'item.url_youtube',
            'type'  => 'youtube'
        ],

        [
            'text'  => 'Actions',
            'value' => 'actions',
        ],
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->success([
            'data'      => [],
            'header'    => $this->headers
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
        if ($id = $request->input('id')) {
            //update
            //jika file nya beda
            if ($request->file('file')) {
                $data = $request->validate([
                    'id'        => 'required',
                    'course_id' => 'required',
                    'name'      => 'required',
                    'desc'      => 'required',
                    'content'   => 'required',
                    'file'      => ['required', 'file', 'mimes:pdf'],
                    'url_youtube'     => ['required', new Youtube()]
                ]);

                $path = "";

                if ($request->file('file')) {
                    $path = 'storage/' . $request->file('file')->store('course/file', 'public');
                }

                $data['file'] = $path;
            } else {
                $data = $request->validate([
                    'id'        => 'required',
                    'course_id' => 'required',
                    'name'      => 'required',
                    'desc'      => 'required',
                    'content'   => 'required',
                    'url_youtube'     => ['required', new Youtube()]
                ]);
            }

            CourseContent::find($data['id'])->update($data);

            return $this->success();
        } else {
            //create

            $data = $request->validate([
                'course_id' => 'required',
                'name'      => 'required',
                'desc'      => 'required',
                'content'   => 'required',
                'file'      => ['required', 'file', 'mimes:pdf'],
                'url_youtube'     => ['required', new Youtube()]
            ]);

            $path = "";

            if ($request->file('file')) {
                $path = 'storage/' . $request->file('file')->store('course/file', 'public');
            }

            $data['file'] = $path;

            CourseContent::create($data);

            return $this->success();
        }
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
                'url_youtube'
            ]),
            'header'    => $this->headers
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
