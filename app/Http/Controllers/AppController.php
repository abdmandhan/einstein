<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Course;
use App\Models\CourseType;
use App\Models\Difficulty;
use App\Models\Discuss;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\User;

class AppController extends Controller
{
    //

    public function index()
    {
        $menuConfig = config('menu');

        $menu = [];
        foreach ($menuConfig as $key => $value) {
            if (in_array(Auth::user()->getRoleNames()[0], $value['roles'])) $menu[] = $value;
        }

        return $this->success([
            'auth'          => Auth::user(),
            'menu'          => $menu,
            'app_name'      => config('app.name'),
        ]);
    }

    public function dashboard()
    {
        return $this->success([
            'cards' => [
                [
                    'title'     => 'Student',
                    'count'     => User::role('student')->count(),
                    'color'     => '#6200ea',
                    'icon'      => 'mdi-account'
                ],
                [
                    'title'     => 'Teacher',
                    'count'     => User::role('teacher')->count(),
                    'color'     => '#6200ea',
                    'icon'      => 'mdi-account-circle-outline'
                ],
                [
                    'title'     => 'Course',
                    'count'     => Course::count(),
                    'color'     => '#6200ea',
                    'icon'      => 'mdi-book'
                ],
                [
                    'title'     => 'Discussion',
                    'count'     => Discuss::count(),
                    'color'     => '#6200ea',
                    'icon'      => 'mdi-book'
                ],
            ]
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

    public function announcement()
    {
        return $this->success(
            Announcement::all()
        );
    }
}
