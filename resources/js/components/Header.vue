<template>
    <header class="site-header">
        <div class="site-header-wrapper width-container">
            <router-link class="site-logo-link" to="/" v-if="isAuth">
                <img class="site-logo" src="/img/logo.png"  alt="Bato Invoices">
            </router-link>
            <router-link class="site-logo-link" to="/login" v-else>
                <img class="site-logo" src="/img/logo.png"  alt="Bato Invoices">
            </router-link>
            <button class="nav-toggle" @click="actionNavToggle($event)">
                <span class="bar-top"></span>
                <span class="bar-mid"></span>
                <span class="bar-bot"></span>
            </button>
            <nav class="main-navigation">
                <ul class="main-nav-list">
                    <li class="main-nav-item" v-if="isAuth">
                        <router-link class="main-nav-link" to="/">Home</router-link>
                    </li>
                    <li class="main-nav-item" v-if="isAuth">
                        <router-link class="main-nav-link" to="/companies-list">Companies</router-link>
                    </li>
                    <li class="main-nav-item" v-if="isAuth && authUser.role == 'admin'">
                        <router-link class="main-nav-link" to="/users-list">Users</router-link>
                    </li>
                    <li class="main-nav-item" v-if="isAuth">
                        <router-link class="main-nav-link" :to="'/my-account/' + authUser.id">My account</router-link>
                    </li>
                    <li class="main-nav-item logout" v-if="isAuth">
                        <a href="#" class="main-nav-link" @click.prevent="actionLogOut">Log out</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
</template>

<script>
    export default {
        components: {},
        data: () => ({
            authUser: [],
            isAuth: false,
        }),
        mounted() {
            this.getAuthUser();
        },
        methods: {
            getAuthUser() {
                axios.get('/api/getAuthUser').then(res => {
                    this.authUser = res.data;
                    if(Object.keys(res.data).length) {
                        this.isAuth = true;
                    }
                })
            },
            actionLogOut() {
                axios({
                    method: 'post',
                    url: '/api/actionLogout',
                    data: {},
                }).then(
                    res => {
                        if (res.data.status === 'success') {
                            this.isAuth = false;
                            this.$router.push('/login');
                        }
                    }
                )
            },
            actionNavToggle(e) {
                var body = document.querySelector('body'),
                    header = document.querySelector('.site-header'),
                    navBlock = document.querySelector('.main-navigation'),
                    navToggle = document.querySelector('.nav-toggle');
                if (navToggle.classList.contains('opened')) {
                    body.classList.remove('stop-scroll');
                    header.classList.remove('nav-opened');
                    navBlock.classList.remove('opened');
                    navToggle.classList.remove('opened');
                } else {
                    body.classList.add('stop-scroll');
                    header.classList.add('nav-opened');
                    navBlock.classList.add('opened');
                    navToggle.classList.add('opened');
                }
            },
        },
    }
</script>

