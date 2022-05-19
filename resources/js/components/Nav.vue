<template>
<nav class="main-navigation">
    <ul class="main-nav-list">
        <li class="main-nav-item" v-if="isAuth">
            <router-link class="main-nav-link" to="/">Home</router-link>
        </li>
        <li class="main-nav-item" v-if="isAuth">
            <router-link class="main-nav-link" to="/companies-list">Companies list</router-link>
        </li>
        <li class="main-nav-item" v-if="isAuth && authUser.role == 'admin'">
            <router-link class="main-nav-link" to="/users-list">Users list</router-link>
        </li>
        <li class="main-nav-item" v-if="isAuth">
            <router-link class="main-nav-link" to="/">My account</router-link>
        </li>
        <li class="main-nav-item logout" v-if="isAuth">
            <a href="#" class="main-nav-link" @click.prevent="actionLogOut">Log out</a>
        </li>
    </ul>
</nav>
</template>

<script>

    // import Vue from 'vue';
    // Vue.forceUpdate();

    export default {
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
                    this.authUser = res.data
                    if(Object.keys(res.data).length) {
                        this.isAuth = true
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
                            // this.$forceUpdate();
                            // console.log(this);
                            this.isAuth = false;
                            this.$router.push('/login');
                        }
                    }
                )
            }
        },
    }
</script>

