<?php

namespace App\Http\Controllers;

use App\Models\Discuss;
use App\Models\DiscussReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscussController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Discuss::with(['replies.user:id,name', 'user:id,name,photo', 'type']);

        if ($request->input('category')) {
            $data->where('course_type_id', $request->input('category'));
        }

        if ($request->input('my')) {
            $data->where('user_id', Auth::id());
        }

        if ($request->input('status')) {
            if ($request->input('status') == 2) $data->where('is_done', 0);
            else $data->where('is_done', $request->input('status'));
        }

        return $this->success(
            $data->orderBy('created_at', $request->input('order', 'asc'))->paginate(5, ['*'], 'page', $request->input('page', 1))
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
        //
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
        //
    }

    public function storeReplies(Request $request)
    {
        $request->validate([
            'text'  => ['required']
        ]);

        $discuss = Discuss::find($request->input('id'));
        $discuss->replies()->create([
            'user_id'   => Auth::id(),
            'text'      => $request->input('text')
        ]);

        return $this->success();
    }

    public function destroyReplies(Request $request, $id)
    {
        DiscussReply::find($id)->delete();

        return $this->success();
    }
}
