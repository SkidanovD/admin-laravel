<template>
    <main class="login-main">
        <div class="login-main__wrapper wrapper">
            <h1 class="login-main__title title">Sign In to Invoice Creator</h1>
            <form class="login-main__form form" method="POST" :action="pageData.login_route">
                <input type="hidden" name="_token" :value="pageData.csrf_token">

                <div class="form__field">
                    <label class="form__label" for="email">Email</label>
                    <input class="form__input" type="email" id="email" name="email" placeholder="mail@gmail.com" required>
                </div>
                <div class="form__field">
                    <label class="form__label" for="password">Password</label>
                    <input class="form__input" type="password" id="password" name="password" placeholder="* * * * * * * *" required>
                </div>

                <div class="form__submit-wrap">
                    <button class="form__submit btn" type="submit">Login</button>
                </div>
            </form>
        </div>
    </main>
</template>

<script>
export default {
    name: 'Login',
    data: () => ({
        pageData: [],
    }),
    mounted() {
        this.loadPageData();
    },
    methods: {
        loadPageData() {
            axios.get('/api/getPageLogin').then(res => {
                this.pageData = res.data
            })
        }
    }
}
</script>
