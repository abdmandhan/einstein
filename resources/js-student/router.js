import Vue from 'vue';
import VueRouter from 'vue-router';

import Dashboard from './components/DashboardComponent';
import DashboardCard from './components/DashboardCardComponent';
import Profile from './components/ProfileComponent';
import Course from './components/CourseComponent';
import CourseJoin from './components/CourseJoinComponent';
import Teacher from './components/TeacherComponent';
import Payment from './components/PaymentComponent';
import Transaction from './components/TransactionComponent';
import Discuss from './components/DiscussComponent';
import TryOut from './components/TryOutComponent';
import Learning from './components/LearningComponent';
import LearningShow from './components/LearningShowComponent';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/student/profile',
            name: 'profile',
            component: Profile,
        },
        {
            path: '/student/dashboard',
            name: 'dashboard',
            component: Dashboard,
            children: [
                {
                    path: '/student/dashboard',
                    // name: 'dashboard',
                    components: {
                        sub: DashboardCard
                    }
                },
                {
                    path: '/student/dashboard/learning',
                    name: 'dashboard.learning',
                    components: {
                        sub: Learning
                    }
                },
                {
                    path: '/student/dashboard/learning/:id',
                    name: 'dashboard.learning.show',
                    components: {
                        sub: LearningShow
                    }
                },
                {
                    path: '/student/dashboard/course',
                    name: 'dashboard.course',
                    components: {
                        sub: Course
                    }
                },
                {
                    path: '/student/dashboard/course/:id',
                    name: 'dashboard.course-join',
                    components: {
                        sub: CourseJoin
                    }
                },
                {
                    path: '/student/dashboard/payment/:id',
                    name: 'dashboard.payment',
                    components: {
                        sub: Payment
                    }
                },
                {
                    path: '/student/dashboard/teacher',
                    name: 'dashboard.teacher',
                    components: {
                        sub: Teacher
                    }
                },
                {
                    path: '/student/dashboard/tryout',
                    name: 'dashboard.tryout',
                    components: {
                        sub: TryOut
                    }
                },
                {
                    path: '/student/dashboard/transaction',
                    name: 'dashboard.transaction',
                    components: {
                        sub: Transaction
                    }
                },
                {
                    path: '/student/dashboard/discussion',
                    name: 'dashboard.discussion',
                    components: {
                        sub: Discuss
                    }
                },
            ]
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