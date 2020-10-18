import Vue from 'vue';
import VueRouter from 'vue-router';

import Dashboard from './components/DashboardComponent';
import Users from './components/UsersComponent';

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
            component: Dashboard
        },
        {
            path: '/vue/coursetasks',
            name: 'coursetasks',
            component: Dashboard
        },
    ]
})

export default router;