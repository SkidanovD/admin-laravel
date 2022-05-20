<template>
    <main class="site-main login-main">
        <div class="site-main-wrapper login-main-wrapper width-container">
            <h1 class="page-title login-page-title">Sign In to Invoice Generator</h1>
            <form class="form login-form" ref="form" @submit.prevent="actionLogin">
                <div class="form-item-wrapper form-item-email-wrapper">
                    <div class="form-input-wrapper form-input-email-wrapper icon-email">
                        <input class="form-input form-input-email" id="email" name="email" type="email" placeholder="Email">
                    </div>
                </div>
                <div class="form-item-wrapper form-item-password-wrapper">
                    <div class="form-input-wrapper form-input-password-wrapper icon-password">
                        <input class="form-input form-input-password" id="password" name="password" type="password" placeholder="Password">
                    </div>
                </div>
                <div class="button-wrapper button-submit-wrapper">
                    <div class="button-hover button-submit-hover">
                        <button class="button button-submit" type="submit">Log in</button>
                    </div>
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
        },
        actionLogin() {
            const formData = new FormData(this.$refs['form']);
            const form_data = new FormData();

            for (let [key, val] of formData.entries()) {
                form_data.append(key, val)
            }
            axios({
                method: 'post',
                url: '/api/actionLogin',
                data: form_data,
            }).then(
                res => {
                    if (res.data.status === 'success') {
                        location = '/';
                        // this.$router.push('/');
                    }
                }
            )
        },
    }
}
</script>
