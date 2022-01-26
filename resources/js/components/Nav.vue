<template>
<nav class="nav">
    <ul class="nav__list">

        <li class="nav__item">
            <router-link class="nav__item-link" to="/">Home</router-link>
        </li>

        <li class="nav__item" v-if="!isAuth">
            <router-link class="nav__item-link" to="/login">Login</router-link>
        </li>

        <li class="nav__item" v-if="authUser.role == 'admin'">
            <router-link class="nav__item-link" to="/register">Register</router-link>
        </li>

        <li class="nav__item" v-if="isAuth">
            <router-link class="nav__item-link" to="/users-list">Users list</router-link>
        </li>

        <li class="nav__item" v-if="isAuth">
            <form method="POST" action="/api/actionLogout">
                <input type="hidden" name="_token" :value="csrfToken">
                <button class="nav__item-link" type="submit">Logout</button>
            </form>
        </li>

    </ul>
</nav>
</template>

<script>

export default {
    data: () => ({
        csrfToken: [],
        authUser: [],
        isAuth: false,
    }),
    mounted() {
        this.getCSRFToken();
        this.getAuthUser();
    },
    methods: {
        getCSRFToken() {
            axios.get('/api/getCSRFToken').then(res => {
                this.csrfToken = res.data
            })
        },
        getAuthUser() {
            axios.get('/api/getAuthUser').then(res => {
                this.authUser = res.data
                if(Object.keys(res.data).length) {
                    this.isAuth = true
                }
            })
        },
    },
}
</script>

