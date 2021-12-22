import vueRouter from 'vue-router';
import Vue from 'vue';

Vue.use(vueRouter);

import Index from './views/Index'
// import User from './views/User'
// import UserList from './views/UserList'
// import EditUser from './views/EditUser'
// import AllMeetings from './views/AllMeetings'
// import Meeting from './views/Meeting'
// import EditMeeting from './views/EditMeeting'

const routes = [
    {
        path: '/',
        title: 'Home',
        component: Index
    },
    // {
    //     path: '/user',
    //     component: User
    // },
    // {
    //     path: '/user-list',
    //     component: UserList
    // },
    // {
    //     path: '/edit-user/:id',
    //     component: EditUser
    // },
    // {
    //     path: '/all-meetings',
    //     component: AllMeetings
    // },
    // {
    //     path: '/meeting/:id',
    //     component: Meeting
    // },
    // {
    //     path: '/edit-meeting/:id',
    //     component: EditMeeting
    // }
];

export default new vueRouter({
    mode: 'history',
    routes
});
