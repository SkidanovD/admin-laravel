<template>
    <main class="site-main edit-user-main">
        <div class="site-main-wrapper edit-user-main-wrapper width-container">
            <h1 class="page-title edit-user-page-title">Edit user</h1>
            <div class="edit-user-photo" v-if="user.photo">
                <div class="image-wrapper">
                    <img :src="user.photo" :alt="user.first_name + user.last_name">
                </div>
            </div>
            <div :class="'text message message-' + formMessage.class" v-if="formMessage.message">{{ formMessage.message }}</div>
            <form ref="form" class="form register-form" @submit.prevent="actionEditUser">
                <input id="id" type="hidden" name="id" :value="user.id">
                <div class="form-item-wrapper form-item-role-wrapper">
                    <div :class="'form-input-wrapper form-select-wrapper form-select-role-wrapper icon-role ' + selectClass" @click="showOptions">
                        <input class="form-input form-input-role form-custom-select" id="role" name="role" type="text" v-model="selectValue" placeholder="User role">
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
                    <div class="form-input-wrapper form-input-first-name-wrapper icon-email">
                        <input class="form-input form-input-first-name" id="first_name" name="first_name" type="text" placeholder="First name" :value="user.first_name">
                    </div>
                    <div class="form-validate-messages message message-error" v-if="validate.first_name">
                        <p class="message-item" v-for="(message, index) in validate.first_name" :key="index">{{ message }}</p>
                    </div>
                </div>
                <div class="form-item-wrapper form-item-last-name-wrapper">
                    <div class="form-input-wrapper form-input-last-name-wrapper icon-email">
                        <input class="form-input form-input-last-name" id="last_name" name="last_name" type="text" placeholder="Last name" :value="user.last_name">
                    </div>
                    <div class="form-validate-messages message message-error" v-if="validate.last_name">
                        <p class="message-item" v-for="(message, index) in validate.last_name" :key="index">{{ message }}</p>
                    </div>
                </div>
                <div class="form-item-wrapper form-item-post-name-wrapper">
                    <div class="form-input-wrapper form-input-post-name-wrapper icon-post">
                        <input class="form-input form-input-post-name" id="user_post" name="user_post" type="text" placeholder="User post" :value="user.user_post">
                    </div>
                    <div class="form-validate-messages message message-error" v-if="validate.user_post">
                        <p class="message-item" v-for="(message, index) in validate.user_post" :key="index">{{ message }}</p>
                    </div>
                </div>
                <div class="form-item-wrapper form-item-email-wrapper">
                    <div class="form-input-wrapper form-input-email-wrapper icon-email">
                        <input class="form-input form-input-email" id="email" name="email" type="email" placeholder="Email" :value="user.email">
                    </div>
                    <div class="form-validate-messages message message-error" v-if="validate.email">
                        <p class="message-item" v-for="(message, index) in validate.email" :key="index">{{ message }}</p>
                    </div>
                </div>
                <div class="form-item-wrapper form-item-password-wrapper">
                    <div class="form-input-wrapper form-input-password-wrapper icon-password">
                        <input class="form-input form-input-password" id="password" name="password" type="password" placeholder="New password">
                    </div>
                    <div class="form-validate-messages message message-error" v-if="validate.password">
                        <p class="message-item" v-for="(message, index) in validate.password" :key="index">{{ message }}</p>
                    </div>
                </div>
                <div class="form-item-wrapper form-item-password-wrapper">
                    <div class="form-input-wrapper form-input-password-wrapper icon-password">
                        <input class="form-input form-input-password" id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirm new password">
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
        name: 'EditUser',
        data: () => ({
            user: [],
            inputSelect: [
                {
                    title: 'Admin',
                    value: 'admin',
                    selected: '' 
                },
                {
                    title: 'User',
                    value: 'user',
                    selected: '' 
                },
            ],
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
        }),
        mounted() {
            this.getUser(this.$route.params.id);
        },
        methods: {
            getUser(id) {
                axios.get('/api/getUser/' + id).then(res => {
                    if (res.data.status === 'success') {
                        this.user = res.data.user;
                        this.selectValue = res.data.user.role;
                    } else {
                        this.formMessage.class = res.data.status;
                        this.formMessage.message = res.data.message;
                    }
                })
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
            onChange() {
                this.formData.photo = this.$refs.form.photo.files[0];
                this.photoLabel = this.$refs.form.photo.files[0].name;
                this.photoClass = '';
            },
            actionEditUser() {
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
                    url: '/api/actionEditUser', 
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
                            this.getUser(this.$route.params.id);
                        }
                    }
                )
            },
        }
    }
</script>
