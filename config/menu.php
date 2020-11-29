<?php

return [
    [
        'header'    => 'Menu',
        'roles'     => ['admin', 'teacher', 'student']
    ],

    [
        'title'     => 'Dashboard',
        'icon'      => 'mdi-view-dashboard',
        'name'      => 'dashboard',
        'roles'     => ['admin', 'teacher']
    ],

    //admin
    [
        'title'     => 'Admin Management',
        'icon'      => 'mdi-account',
        'name'      => 'users',
        'roles'     => ['admin']
    ],

    [
        'title'     => 'Teacher Management',
        'icon'      => 'mdi-account-circle-outline',
        'name'      => 'teachers',
        'roles'     => ['admin']
    ],

    [
        'title'     => 'Student Management',
        'icon'      => 'mdi-account-group-outline',
        'name'      => 'students',
        'roles'     => ['admin']
    ],

    //teacher
    [
        'title'     => 'Courses Management',
        'icon'      => 'mdi-book-open-page-variant',
        'name'      => 'courses',
        'roles'     => ['admin', 'teacher']
    ],

    [
        'title'     => 'Transaction',
        'icon'      => 'mdi-cart',
        'name'      => 'transactions',
        'roles'     => ['admin', 'teacher']
    ],

    [
        'title'     => 'Try Out',
        'icon'      => 'mdi-clipboard-outline',
        'name'      => 'tryouts',
        'roles'     => ['admin', 'teacher']
    ],

    [
        'title'     => 'Discussion',
        'icon'      => 'mdi-clipboard-outline',
        'name'      => 'discuss',
        'roles'     => ['admin', 'teacher']
    ],


    //cms
    [
        'header'    => 'Content Management',
        'roles'     => ['admin']
    ],


    [
        'title'     => 'Course Type',
        'icon'      => 'mdi-book',
        'name'      => 'coursetypes',
        'roles'     => ['admin', 'teacher']
    ],

    [
        'title'     => 'Grade',
        'icon'      => 'mdi-school',
        'name'      => 'grades',
        'roles'     => ['admin']
    ],

    [
        'title'     => 'Difficulty',
        'icon'      => 'mdi-chart-box',
        'name'      => 'difficulties',
        'roles'     => ['admin']
    ],

    // [
    //     'title'     => 'Position',
    //     'icon'      => 'mdi-shield-account',
    //     'name'      => 'positions',
    //     'roles'     => ['admin']
    // ],

    [
        'title'     => 'Transaction Status',
        'icon'      => 'mdi-cash-100',
        'name'      => 'transactionstatuses',
        'roles'     => ['admin']
    ],



];
