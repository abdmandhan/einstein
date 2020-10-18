<?php

return [
    [
        'title'     => 'Dashboard',
        'icon'      => 'mdi-home-city',
        'name'      => 'dashboard',
        'roles'     => ['admin']
    ],

    //admin
    [
        'title'     => 'Users Management',
        'icon'      => 'mdi-account',
        'name'      => 'users',
        'roles'     => ['admin', 'teacher']
    ],

    //teacher
    [
        'title'     => 'Courses Management',
        'icon'      => 'mdi-account-group-outline',
        'name'      => 'courses',
        'roles'     => ['admin', 'teacher']
    ],

    [
        'title'     => 'Course Tasks Management',
        'icon'      => 'mdi-account-group-outline',
        'name'      => 'coursetasks',
        'roles'     => ['admin', 'teacher']
    ],

];
