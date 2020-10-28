import Vue from 'vue';
import VueRouter from 'vue-router';

import Dashboard from './components/DashboardComponent';
import Profile from './components/ProfileComponent';

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
            path: '/student/my-course',
            name: 'my-course',
            component: Dashboard
        },
        {
            path: '/student/tryout',
            name: 'tryout',
            component: Dashboard
        },
    ]
})

export default router;