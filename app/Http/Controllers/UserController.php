<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->success([
            'data'      => User::all([
                'id',
                'name',
                'address',
                'phone',
                'email',
                'created_at'
            ]),
            'header'    => [
                [
                    'text'  => 'ID',
                    'value' => 'id'
                ],
                [
                    'text'  => 'Name',
                    'value' => 'name'
                ],
                [
                    'text'  => 'Email',
                    'value' => 'email'
                ],
                [
                    'text'  => 'Phone',
                    'value' => 'phone'
                ],
                [
                    'text'  => 'Address',
                    'value' => 'address'
                ],
                [
                    'text'  => 'Role',
                    'value' => 'role',
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
        $data = collect($request->validate([
            'id'        => 'nullable',
            'name'      => 'required',
            'email'     => ['required',  Rule::unique('users')->ignore($request->input('id')), 'email'],
            'password'  => [Rule::requiredIf(!$request->input('id'))],
            'address'   => 'required',
            'phone'     => 'required',
            'role'      => 'required'
        ]));

        if (isset($data['id'])) {
            $user = User::find($data['id'])->update($data->except('role')->toArray());
            $user = User::find($data['id']);
        } else {
            $user = User::create($data->except('role')->toArray());
        }

        $user->syncRoles($data->get('role'));

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
        //
    }
}
