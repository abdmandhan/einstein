<?php

return [
    [
        'header'    => 'Menu',
        'roles'     => ['admin']
    ],

    [
        'title'     => 'Dashboard',
        'icon'      => 'mdi-view-dashboard',
        'name'      => 'dashboard',
        'roles'     => ['admin']
    ],

    //admin
    [
        'title'     => 'Users Management',
        'icon'      => 'mdi-account-group-outline',
        'name'      => 'users',
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
