<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseType;
use App\Models\Difficulty;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

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
            'app_name'      => config('app.name'),
        ]);
    }

    public function options()
    {
        $data = [
            'roles'         => Role::all(['id', 'name']),
            'grades'        => Grade::all(['id', 'name']),
            'course_types'  => CourseType::all(['id', 'name']),
            'courses'       => Course::all(['id', 'name']),
            'difficulties'  => Difficulty::all(['id', 'name'])
        ];

        return response()->json($data);
    }
}
