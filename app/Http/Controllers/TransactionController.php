<?php

namespace App\Http\Controllers;

use App\Models\CourseStudent;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
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
            'data'          => Transaction::with([
                'transaction_status',
                'course',
            ])->get([
                'id',
                'user_id',
                'course_id',
                'transaction_status_id',
                'transaction_date',
                'amount',
                'image',
                'account_no',
                'account_name'
            ])->append([
                'user_name'
            ]),
            'header'        => [
                [
                    'text'  => 'ID',
                    'value' => 'id'
                ],
                [
                    'text'  => 'Course',
                    'value' => 'course_id'
                ],
                [
                    'text'  => 'User',
                    'value' => 'user_name'
                ],
                [
                    'text'  => 'Transaction Status',
                    'value' => 'transaction_status_id'
                ],
                [
                    'text'  => 'Transaction Date',
                    'value' => 'transaction_date'
                ],
                [
                    'text'  => 'Proof',
                    'value' => 'image'
                ],
                [
                    'text'  => 'Amount',
                    'value' => 'amount'
                ],
                [
                    'text'  => 'Account Number',
                    'value' => 'account_no'
                ],
                [
                    'text'  => 'Account Name',
                    'value' => 'account_name'
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
        $data = (object) $request->validate([
            'status'    => ['required']
        ]);

        $transaction = Transaction::find($id);

        if ($data->status == 2) {
            CourseStudent::create([
                'user_id'       => $transaction->user_id,
                'course_id'     => $transaction->course_id,
            ]);
        }

        Transaction::findOrFail($id)->update(['transaction_status_id' => $request->input('status')]);

        $message = $data->status == 2 ? 'Accept' : 'Reject';

        return $this->success([], "Success $message!");
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
