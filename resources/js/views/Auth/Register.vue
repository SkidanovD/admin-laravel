<template>
    <main class="register-main">
        <div class="register-main__wrapper wrapper">
            <h1 class="register-main__title title title_center">Register page</h1>
            <form ref="form" class="form" @submit.prevent="onFormSubmit" v-if="!form_sent">
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
                        <input id="photo" type="file" name="photo" v-on:change="onChange">
                        <span class="form__field-error" v-if="messages.photo">{{ messages.photo }}</span>
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
                        <span class="form__field-error" v-if="messages.email">{{ messages.email }}</span>
                    </div>
                </div>
                <div class="form__row">
                    <div class="form__field">
                        <label class="form__label" for="password">Password</label>
                        <input class="form__input" type="password" id="password" name="password" placeholder="* * * * * * * *" required>
                        <span class="form__field-error" v-if="messages.password">{{ messages.password }}</span>
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

            <div class="form-message title" v-if="form_sent">User created successfully</div>
        </div>
    </main>
</template>

<script>
export default {
    name: 'Register',
    data: () => ({
        headers: {
            'content-type': 'multipart/form-data'
        },
        pageData: [],
        contacts: {
            role: '',
            photo: '',
            first_name: '',
            last_name: '',
            user_post: '',
            email: '',
            password: '',
            password_confirmation: '',
        },
        messages: {
            photo: '',
            email: '',
            password: '',
        },
        form_sent: false
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
        onChange() {
            this.contacts.photo = this.$refs.form.photo.files[0];
        },
        onFormSubmit() {      
            const formData = new FormData(this.$refs['form']);
            const form_data = new FormData();

            for (let [key, val] of formData.entries()) {
                form_data.append(key, val)
            }
            if (this.contacts.photo.name) {
                form_data.append('photo', this.contacts.photo, this.contacts.photo.name);
            }
            

            axios({
                method: 'post',
                url: this.pageData.register_route, 
                data: form_data, 
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(
                res => {
                    if(res.data.status == 'success') {
                        this.form_sent = true
                    } else {
                        for(let key in res.data.messages) {
                            this.messages[key] = res.data.messages[key][0];
                        }
                    }
                }
            )
        }
    }
}
</script>
