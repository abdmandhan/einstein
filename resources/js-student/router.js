import Vue from 'vue';
import VueRouter from 'vue-router';

import Dashboard from './components/DashboardComponent';
import Profile from './components/ProfileComponent';
import Course from './components/CourseComponent';
import CourseJoin from './components/CourseJoinComponent';
import Teacer from './components/TeacherComponent';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes:[
        {
            path: '/student/profile',
            name: 'profile',
            component: Profile
        },
        {
            path: '/student/dashboard',
            name: 'dashboard',
            component: Dashboard
        },
        {
            path: '/student/course',
            name: 'course',
            component: Course
        },
        {
            path: '/student/teacher',
            name: 'teacher',
            component: Teacer
        },
        {
            path: '/student/course/:id',
            name: 'course-join',
            component: CourseJoin
        },
        {
            path: '/student/tryout',
            name: 'tryout',
            component: Dashboard
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