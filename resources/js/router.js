import vueRouter from 'vue-router';
import Vue from 'vue';

Vue.use(vueRouter);

import Index from './views/Index'
import Register from './views/auth/Register'
import Login from './views/auth/Login'
import UsersList from './views/Users/UsersList'
import EditUser from './views/Users/EditUser'
import MyAccount from './views/Users/MyAccount'
import CompaniesList from './views/Companies/CompaniesList'
import AddCompany from './views/Companies/AddCompany'
import EditCompany from './views/Companies/EditCompany'
import AddInvoice from './views/Invoices/AddInvoice'
import EditInvoice from './views/Invoices/EditInvoice'

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
    {
        path: '/my-account/:id',
        component: MyAccount,
    },
    {
        path: '/companies-list',
        component: CompaniesList,
    },
    {
        path: '/add-company',
        component: AddCompany,
    },
    {
        path: '/edit-company/:id',
        component: EditCompany,
    },
    {
        path: '/add-invoice',
        component: AddInvoice,
    },
    {
        path: '/edit-invoice/:id',
        component: EditInvoice,
    },
];

export default new vueRouter({
    mode: 'history',
    routes
});
