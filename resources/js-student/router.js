import Vue from 'vue';
import VueRouter from 'vue-router';

import Dashboard from './components/DashboardComponent';
import Profile from './components/ProfileComponent';
import Course from './components/CourseComponent';
import CourseJoin from './components/CourseJoinComponent';
import Teacher from './components/TeacherComponent';
import Payment from './components/PaymentComponent';
import Transaction from './components/TransactionComponent';
import Discuss from './components/DiscussComponent';
import TryOut from './components/TryOutComponent';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes:[
        {
            path: '/student/profile',
            name: 'profile',
            component: Profile,
        },
        {
            path: '/student/dashboard',
            name: 'dashboard',
            component: Dashboard,
            children:[
                {
                    path: '/student/dashboard/course',
                    name: 'dashboard.course',
                    components:{
                        sub: Course
                    }
                },
                {
                    path: '/student/dashboard/course/:id',
                    name: 'dashboard.course-join',
                    components:{
                        sub: CourseJoin
                    }
                },
                {
                    path: '/student/dashboard/teacher',
                    name: 'dashboard.teacher',
                    components:{
                        sub: Teacher
                    }
                },
                {
                    path: '/student/dashboard/transaction',
                    name: 'dashboard.transaction',
                    components:{
                        sub: Transaction
                    }
                },
                {
                    path: '/student/dashboard/discussion',
                    name: 'dashboard.discussion',
                    components:{
                        sub: Discuss
                    }
                },
            ]
        },
        {
            path: '/student/course',
            name: 'course',
            component: Course
        },
        {
            path: '/student/teacher',
            name: 'teacher',
            component: Teacher
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
            path: '/student/transaction',
            name: 'transaction',
            component: Transaction
        },
        {
            path: '/student/discussion',
            name: 'discussion',
            component: Discuss
        },
        {
            path: '/student/payment/:id',
            name: 'payment',
            component: Payment
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