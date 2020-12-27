import Vue from 'vue';
import VueRouter from 'vue-router';

import Dashboard from './components/DashboardComponent';
import Users from './components/UsersComponent';
import Teachers from './components/TeachersComponent';
import Students from './components/StudentsComponent';
import Courses from './components/course/CoursesComponent';
import CourseTask from './components/course/CourseTaskComponent';
import CourseEdit from './components/course/CourseEditComponent';
import CourseCreate from './components/course/CourseCreateComponent';
import CourseTypes from './components/CourseTypesComponent';
import Grades from './components/GradesComponent';
import Difficulties from './components/DifficultiesComponent';
import Positions from './components/PositionsComponent';
import TransactionStatuses from './components/TransactionStatusesComponent';
import Transaction from './components/TransactionComponent';
import Discuss from './components/DiscussComponent';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/vue/dashboard',
            name: 'dashboard',
            component: Dashboard
        },
        {
            path: '/vue/users',
            name: 'users',
            component: Users,
        },
        {
            path: '/vue/teachers',
            name: 'teachers',
            component: Teachers,
        },
        {
            path: '/vue/students',
            name: 'students',
            component: Students,
        },
        {
            path: '/vue/courses',
            name: 'courses',
            component: Courses
        },
        {
            path: '/vue/course-task/:id',
            name: 'course-task',
            component: CourseTask
        },
        {
            path: '/vue/course/create',
            name: 'course.create',
            component: CourseCreate
        },
        {
            path: '/vue/course/:course_id',
            name: 'course.edit',
            component: CourseEdit
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
            path: '/vue/discuss',
            name: 'discuss',
            component: Discuss
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