import Vue from 'vue';
import VueRouter from 'vue-router';

import Dashboard from './components/DashboardComponent';
import Users from './components/UsersComponent';
import Courses from './components/CoursesComponent';
import CourseTypes from './components/CourseTypesComponent';
import Grades from './components/GradesComponent';
import Difficulties from './components/DifficultiesComponent';
import Positions from './components/PositionsComponent';
import TransactionStatuses from './components/TransactionStatusesComponent';
import Transaction from './components/TransactionComponent';

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
            component: CourseTypes
        },
        {
            path: '/vue/transactions',
            name: 'transactions',
            component: Transaction
        },
        {
            path: '/vue/tryouts',
            name: 'tryouts',
            component: Dashboard
        },
        {
            path: '/vue/grades',
            name: 'grades',
            component: Grades
        },
        {
            path: '/vue/difficulties',
            name: 'difficulties',
            component: Difficulties
        },

        {
            path: '/vue/positions',
            name: 'positions',
            component: Positions
        },
        {
            path: '/vue/transactionstatuses',
            name: 'transactionstatuses',
            component: TransactionStatuses
        },
        {
            path: "*",
            redirect: "/404"
        },
        {
            path: "/404",
            name: "404",
        }

    ]
})

export default router;