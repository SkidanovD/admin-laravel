<template>
    <main class="site-main register-main">
        <div class="site-main-wrapper register-main-wrapper width-container">
            <h1 class="page-title register-page-title">Add user</h1>
            <div :class="'text message message-' + formMessage.class" v-if="formMessage.message">{{ formMessage.message }}</div>
            <div class="return-user-list-button button-wrapper" v-if="formMessage.class && formMessage.class === 'success'">
               <div class="button-hover">
                  <router-link to="/users-list" class="button">Back to user list</router-link>
               </div>
            </div>
            <form ref="form" class="form register-form" @submit.prevent="actionAddUser" v-if="formMessage.class !== 'success'">
                <div class="form-item-wrapper form-item-role-wrapper">
                    <div :class="'form-input-wrapper form-select-wrapper form-select-role-wrapper icon-role ' + selectClass" @click="showOptions">
                        <input class="form-input form-input-role form-custom-select" id="role" name="role" type="text" v-model="formData.role" placeholder="User role">
                        <ul class="select-option-list" v-if="selectVisibility">
                            <div class="select-option" data-role="admin" v-on:click="selectRole">Admin</div>
                            <div class="select-option" data-role="user" v-on:click="selectRole">User</div>
                        </ul>
                    </div>
                    <div class="form-validate-messages message message-error" v-if="validate.role">
                        <p class="message-item" v-for="(message, index) in validate.role" :key="index">{{ message }}</p>
                    </div>
                </div>
                <div class="form-item-wrapper form-item-photo-wrapper">
                    <div class="form-input-wrapper form-input-photo-wrapper icon-photo">
                        <label for="photo" :class="'form-label form-label-file' + photoClass">{{ photoLabel }}</label>
                        <input class="form-input form-input-file form-input-photo" id="photo" type="file" name="photo" v-on:change="onChange">
                    </div>
                    <div class="form-validate-messages message message-error" v-if="validate.photo">
                        <p class="message-item" v-for="(message, index) in validate.photo" :key="index">{{ message }}</p>
                    </div>
                </div>
                <div class="form-item-wrapper form-item-first-name-wrapper">
                    <div class="form-input-wrapper form-input-first-name-wrapper icon-name">
                        <input class="form-input form-input-first-name" id="first_name" name="first_name" type="text" placeholder="First name">
                    </div>
                </div>
                <div class="form-item-wrapper form-item-last-name-wrapper">
                    <div class="form-input-wrapper form-input-last-name-wrapper icon-name">
                        <input class="form-input form-input-last-name" id="last_name" name="last_name" type="text" placeholder="Last name">
                    </div>
                </div>
                <div class="form-item-wrapper form-item-post-name-wrapper">
                    <div class="form-input-wrapper form-input-post-name-wrapper icon-post">
                        <input class="form-input form-input-post-name" id="user_post" name="user_post" type="text" placeholder="User post">
                    </div>
                </div>
                <div class="form-item-wrapper form-item-email-wrapper">
                    <div class="form-input-wrapper form-input-email-wrapper icon-email">
                        <input class="form-input form-input-email" id="email" name="email" type="email" placeholder="Email">
                    </div>
                    <div class="form-validate-messages message message-error" v-if="validate.email">
                        <p class="message-item" v-for="(message, index) in validate.email" :key="index">{{ message }}</p>
                    </div>
                </div>
                <div class="form-item-wrapper form-item-password-wrapper">
                    <div class="form-input-wrapper form-input-password-wrapper icon-password">
                        <input class="form-input form-input-password" id="password" name="password" type="password" placeholder="Password">
                    </div>
                    <div class="form-validate-messages message message-error" v-if="validate.password">
                        <p class="message-item" v-for="(message, index) in validate.password" :key="index">{{ message }}</p>
                    </div>
                </div>
                <div class="form-item-wrapper form-item-password-wrapper">
                    <div class="form-input-wrapper form-input-password-wrapper icon-password">
                        <input class="form-input form-input-password" id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirm password">
                    </div>
                </div>
                <div class="button-wrapper button-submit-wrapper">
                    <div class="button-hover button-submit-hover">
                        <button class="button button-submit" type="submit">Add user</button>
                    </div>
                </div>
            </form>
        </div>
    </main>
</template>

<script>
export default {
    name: 'Register',
    data() {
        return {
            selectVisibility: false,
            selectValue: '',
            selectClass: '',
            photoLabel: 'Photo',
            photoClass: ' placeholder',
            headers: {
                'content-type': 'multipart/form-data'
            },
            pageData: [],
            formData: {
                role: '',
                photo: '',
                first_name: '',
                last_name: '',
                user_post: '',
                email: '',
                password: '',
                password_confirmation: '',
            },
            validate: {},
            formMessage: {
                class: '',
                message: '',
            },
        }
    },
    mounted() {
        this.loadPageData();
    },
    methods: {
        loadPageData() {
            axios.get('/api/getPageRegister').then(res => {
                this.pageData = res.data
            })
        },
        onChange(e) {
            this.formData.photo = this.$refs.form.photo.files[0];
            this.photoLabel = this.$refs.form.photo.files[0].name;
            this.photoClass = '';
        },
        showOptions(e) {
            this.selectVisibility = !this.selectVisibility;
            if (this.selectClass === '') {
                this.selectClass = 'opened';
            } else {
                this.selectClass = '';
            }
        },
        selectRole(e) {
            this.formData.role = e.target.dataset.role;
        },
        actionAddUser() {
            const formData = new FormData(this.$refs['form']);
            const form_data = new FormData();

            for (let [key, val] of formData.entries()) {
                form_data.append(key, val)
            }
            if (this.formData.photo.name) {
                form_data.append('photo', this.formData.photo, this.formData.photo.name);
            }

            axios({
                method: 'post',
                url: '/api/actionAddUser', 
                data: form_data, 
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(
                res => {
                    if (res.data.status === 'not validated') {
                        for(let key in res.data.messages) {
                            this.$set(this.validate, key, res.data.messages[key]);
                        }
                    } else {
                        this.formMessage.class = res.data.status;
                        this.formMessage.message = res.data.message;
                    }
                }
            )
        },
    }
}
</script>
