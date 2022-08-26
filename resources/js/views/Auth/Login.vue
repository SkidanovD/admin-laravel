<template>
    <main class="site-main login-main">
        <div class="site-main-wrapper login-main-wrapper width-container">
            <h1 class="page-title login-page-title">Sign In to Invoice Generator</h1>
            <div :class="'text message message-' + formMessage.class" v-if="formMessage.message">{{ formMessage.message }}</div>
            <form class="form login-form" ref="form" @submit.prevent="actionLogin">
                <div class="form-item-wrapper form-item-email-wrapper">
                    <div class="form-input-wrapper form-input-email-wrapper icon-email">
                        <input class="form-input form-input-email" id="email" name="email" type="email" placeholder="Email">
                    </div>
                    <vueValidateMessage  v-if="validate.email" :messages="validate.email"></vueValidateMessage>
                </div>
                <div class="form-item-wrapper form-item-password-wrapper">
                    <div class="form-input-wrapper form-input-password-wrapper icon-password">
                        <input class="form-input form-input-password" id="password" name="password" type="password" placeholder="Password">
                    </div>
                    <vueValidateMessage  v-if="validate.password" :messages="validate.password"></vueValidateMessage>
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

    import vueValidateMessage from './../../components/MessageValidate';
    export default {
        name: 'Login',
        components: {
            vueValidateMessage,
        },
        data: () => ({
            pageData: [],
            validate: {},
            formMessage: {
                class: '',
                message: '',
            },
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
                        this.formMessage.class = '';
                        this.formMessage.message = '';
                        this.validate = {};
                        if (res.data.status === 'not validated') {
                            for(let key in res.data.messages) {
                                this.$set(this.validate, key, res.data.messages[key]);
                            }
                            this.scrollToElement('form-validate-messages');
                        } else if (res.data.status === 'success') {
                            location = '/';
                            // this.$router.push('/');
                        } else {
                            this.formMessage.class = 'error';
                            this.formMessage.message = res.data.message;
                            this.scrollToElement();
                        }
                    }
                )
            },
            scrollToElement(elem = '') {
                var $this = this;
                var el = this.$el;
                
                setTimeout(function() {
                    if (elem) {
                        el = $this.$el.getElementsByClassName(elem)[0];
                    }
                    if (el) {
                        window.scrollTo({
                            top: el.getBoundingClientRect().top + document.documentElement.scrollTop - 100,
                            behavior: 'smooth'
                        });
                    }
                }, 100);
                
            },
        }
    }
</script>
