<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        foreach (Auth::user()->getRoleNames() as $key => $value) {
            if ($value == 'student') {
                return redirect('student/dashboard');
            }
        }

        return redirect('vue/dashbaord');
    }
}
