<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    //

    public function index(Request $request)
    {
        $menu = collect(config('menu'));
        $menu = $menu->map(function ($item, $key) {
            return in_array(Auth::user()->getRoleNames()[0], $item['roles']) ? $item : null;
        });

        return response()->json([
            'auth'          => $request->user(),
            'menu'          => $menu,
            'app_name'      => config('app.name')
        ]);
    }
}
