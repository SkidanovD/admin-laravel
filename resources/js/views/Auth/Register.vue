<template>
    <main class="register-main">
        <div class="register-main__wrapper wrapper">
            <h1 class="register-main__title title title_center">Register page</h1>
            <form ref="form" class="form" method="POST" :action="pageData.register_route" enctype="multipart/form-data" @submit.prevent="onFormSubmit">
                <input class="form__input" type="hidden" name="_token" :value="pageData.csrf_token">

                <div class="form__row">
                    <div class="form__field">
                        <select class="form__input" id="role" name="role" required>
                            <option value="" selected>User Role</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                </div>

                <div class="form__row">
                    <div class="form__field">
                        <label class="form__label" for="photo">Photo</label>
                        <input id="photo" type="file" name="photo">
                    </div>
                </div>

                <div class="form__row">
                    <div class="form__field">
                        <label class="form__label" for="first_name">First Name</label>
                        <input class="form__input" type="text" id="first_name" name="first_name" placeholder="Vasyl">
                    </div>
                    <div class="form__field">
                        <label class="form__label" for="last_name">Last Name</label>
                        <input class="form__input" type="text" id="last_name" name="last_name" placeholder="Stus">
                    </div>
                </div>

                <div class="form__row">
                    <div class="form__field">
                        <label class="form__label" for="user_post">User Post</label>
                        <input class="form__input" type="text" id="user_post" name="user_post" placeholder="Ukrainskiy poet, politzaklyuchenniy">
                    </div>
                </div>
                <div class="form__row">
                    <div class="form__field">
                        <label class="form__label" for="email">Email</label>
                        <input class="form__input" type="email" id="email" name="email" placeholder="mail@gmail.com" required>
                    </div>
                </div>
                <div class="form__row">
                    <div class="form__field">
                        <label class="form__label" for="password">Password</label>
                        <input class="form__input" type="password" id="password" name="password" placeholder="* * * * * * * *" required>
                    </div>
                    <div class="form__field">
                        <label class="form__label" for="password-confirm">Confirm password</label>
                        <input class="form__input" id="password-confirm" type="password" name="password_confirmation" placeholder="* * * * * * * *" required>
                    </div>
                </div>
                <div class="form__submit-wrap">
                    <button class="form__submit btn" type="submit">Register</button>
                </div>
            </form>
        </div>
    </main>
</template>

<script>
export default {
    name: 'Register',
    data: () => ({
        pageData: [],
    }),
    mounted() {
        this.loadPageData();
    },
    methods: {
        loadPageData() {
            axios.get('/api/getPageRegister').then(res => {
                this.pageData = res.data
            })
        },
        onFormSubmit() {              
            const formData = new FormData(this.$refs['form']);
            const data = {};
            for (let [key, val] of formData.entries()) {
                Object.assign(data, { [key]: val })
            }
            console.log(formData);
            axios.post(this.pageData.register_route, data).then(res => console.log(res.request.response))
        }
    }
}
</script>
