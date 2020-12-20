<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Announcement;
use App\Models\Course;
use App\Models\CourseStudent;
use App\Models\CourseType;
use App\Models\Difficulty;
use App\Models\Discuss;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\TryOutStudent;
use App\Models\TryOut;

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
        //check absen
        $date_now = date_format(date_create(now()), 'yy-m-d');
        $absensi = Absensi::where('user_id', Auth::id())->where('date', '>=', $date_now)->first();
        if ($absensi == null) {
            Absensi::create([
                'user_id'   => Auth::id(),
                'date'      => now()
            ]);
        }

        $tryout_student = TryOutStudent::with(['tryout'])->where('user_id', Auth::id())->get();
        return $this->success([
            'auth'          => Auth::user(),
            'announcements'  => Announcement::all(),
            'courses'        => CourseStudent::with(['course'])->where('user_id', Auth::id())->get(),
            'tryout'        => [
                'all'       => TryOut::all(),
                'ongoing'   => $tryout_student->where('score', null),
                'finish'    => $tryout_student->where('score')->values(),
            ],
            'absensi'       => Absensi::where('user_id', Auth::id())->get()

        ]);
    }
}
