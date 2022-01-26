import vueRouter from 'vue-router';
import Vue from 'vue';

Vue.use(vueRouter);

import Index from './views/Index'
import Register from './views/auth/Register'
import Login from './views/auth/Login'
import UsersList from './views/UsersList'
import EditUser from './views/EditUser'

const routes = [
    {
        path: '/',
        component: Index,
    },
    {
        path: '/login',
        component: Login
    },
    {
        path: '/register',
        component: Register,
    },
    {
        path: '/users-list',
        component: UsersList,
    },
    {
        path: '/edit-user/:id',
        component: EditUser,
    },
];

export default new vueRouter({
    mode: 'history',
    routes
});
