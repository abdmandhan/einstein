import Vue from 'vue';
import VueRouter from 'vue-router';

import Dashboard from './components/DashboardComponent';
import Users from './components/UsersComponent';
import Courses from './components/CoursesComponent';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes:[
        {
            path: '/vue/dashboard',
            name: 'dashboard',
            component: Dashboard
        },
        {
            path: '/vue/users',
            name: 'users',
            component: Users
        },
        {
            path: '/vue/courses',
            name: 'courses',
            component: Courses
        },
        {
            path: '/vue/coursetypes',
            name: 'coursetypes',
            component: Dashboard
        },
        {
            path: '/vue/transactions',
            name: 'transactions',
            component: Dashboard
        },
        {
            path: '/vue/tryouts',
            name: 'tryouts',
            component: Dashboard
        },
        {
            path: '/vue/grades',
            name: 'grades',
            component: Dashboard
        },
        {
            path: '/vue/difficulties',
            name: 'difficulties',
            component: Dashboard
        },

        {
            path: '/vue/positions',
            name: 'positions',
            component: Dashboard
        },
        {
            path: '/vue/transactionstatuses',
            name: 'transactionstatuses',
            component: Dashboard
        },
    ]
})

export default router;