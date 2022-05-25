<template>
    <main class="site-main add-company-main">
        <div class="site-main-wrapper add-company-main-wrapper width-container">
            <h1 class="page-title add-company-page-title">Add company</h1>
            <div :class="'text message message-' + formMessage.class" v-if="formMessage.message">{{ formMessage.message }}</div>
            <div class="return-company-list-button button-wrapper" v-if="formMessage.class && formMessage.class === 'success'">
               <div class="button-hover">
                  <router-link to="/companies-list" class="button">Back to company list</router-link>
               </div>
            </div>
            <form ref="form" class="form add-company-form" @submit.prevent="actionAddCompany" v-if="formMessage.class !== 'success'">
                <div class="form-item-wrapper form-item-name-wrapper">
                    <div class="form-input-wrapper form-input-name-wrapper icon-name">
                        <input class="form-input form-input-name" id="name" name="name" type="text" placeholder="Name">
                    </div>
                    <div class="form-validate-messages message message-error" v-if="validate.name">
                        <p class="message-item" v-for="(message, index) in validate.name" :key="index">{{ message }}</p>
                    </div>
                </div>
                <div class="form-item-wrapper form-item-company-name-wrapper required">
                    <div class="form-input-wrapper form-input-company-name-wrapper icon-name">
                        <input class="form-input form-input-company-name" id="company_name" name="company_name" type="text" placeholder="Company name">
                    </div>
                    <div class="form-validate-messages message message-error" v-if="validate.company_name">
                        <p class="message-item" v-for="(message, index) in validate.company_name" :key="index">{{ message }}</p>
                    </div>
                </div>
                <div class="form-item-wrapper form-item-address-wrapper">
                    <div class="form-input-wrapper form-input-address-wrapper icon-name">
                        <input class="form-input form-input-address" id="address" name="address" type="text" placeholder="Address">
                    </div>
                    <div class="form-validate-messages message message-error" v-if="validate.address">
                        <p class="message-item" v-for="(message, index) in validate.address" :key="index">{{ message }}</p>
                    </div>
                </div>
                <div class="form-item-wrapper form-item-post-code-wrapper">
                    <div class="form-input-wrapper form-input-post-code-wrapper icon-name">
                        <input class="form-input form-input-post-code" id="post_code" name="post_code" type="text" placeholder="Post code">
                    </div>
                    <div class="form-validate-messages message message-error" v-if="validate.post_code">
                        <p class="message-item" v-for="(message, index) in validate.post_code" :key="index">{{ message }}</p>
                    </div>
                </div>
                <div class="form-item-wrapper form-item-city-wrapper">
                    <div class="form-input-wrapper form-input-city-wrapper icon-name">
                        <input class="form-input form-input-city" id="city" name="city" type="text" placeholder="City">
                    </div>
                    <div class="form-validate-messages message message-error" v-if="validate.city">
                        <p class="message-item" v-for="(message, index) in validate.city" :key="index">{{ message }}</p>
                    </div>
                </div>
                <div class="form-item-wrapper form-item-phone-wrapper">
                    <div class="form-input-wrapper form-input-phone-wrapper icon-name">
                        <input class="form-input form-input-phone" id="phone" name="phone" type="text" placeholder="Telephone">
                    </div>
                    <div class="form-validate-messages message message-error" v-if="validate.phone">
                        <p class="message-item" v-for="(message, index) in validate.phone" :key="index">{{ message }}</p>
                    </div>
                </div>
                <div class="form-item-wrapper form-item-siret-wrapper">
                    <div class="form-input-wrapper form-input-siret-wrapper icon-name">
                        <input class="form-input form-input-siret" id="siret" name="siret" type="text" placeholder="Siret">
                    </div>
                    <div class="form-validate-messages message message-error" v-if="validate.siret">
                        <p class="message-item" v-for="(message, index) in validate.siret" :key="index">{{ message }}</p>
                    </div>
                </div>
                <div class="form-item-wrapper form-item-rcs-wrapper">
                    <div class="form-input-wrapper form-input-rcs-wrapper icon-name">
                        <input class="form-input form-input-rcs" id="rcs" name="rcs" type="text" placeholder="RCS">
                    </div>
                    <div class="form-validate-messages message message-error" v-if="validate.rcs">
                        <p class="message-item" v-for="(message, index) in validate.rcs" :key="index">{{ message }}</p>
                    </div>
                </div>
                <div class="form-item-wrapper form-item-tva-wrapper">
                    <div class="form-input-wrapper form-input-tva-wrapper icon-name">
                        <input class="form-input form-input-tva" id="tva" name="tva" type="text" placeholder="TVA">
                    </div>
                    <div class="form-validate-messages message message-error" v-if="validate.tva">
                        <p class="message-item" v-for="(message, index) in validate.tva" :key="index">{{ message }}</p>
                    </div>
                </div>
                <div class="form-item-wrapper form-item-note-wrapper">
                    <div class="form-input-wrapper form-textarea-wrapper form-textarea-note-wrapper icon-name">
                        <input class="form-input form-textarea form-textarea-note" id="note" name="note" type="textarea" placeholder="Note">
                    </div>
                    <div class="form-validate-messages message message-error" v-if="validate.note">
                        <p class="message-item" v-for="(message, index) in validate.note" :key="index">{{ message }}</p>
                    </div>
                </div>
                <div class="button-wrapper button-submit-wrapper">
                    <div class="button-hover button-submit-hover">
                        <button class="button button-submit" type="submit">Add company</button>
                    </div>
                </div>
                <!-- <div>
                    <input class="form__input" type="hidden" name="_token" :value="pageData.csrf_token">
                    <div class="form__row">
                        <div class="form__field">
                            <label class="form__label" for="name">Name</label>
                            <input class="form__input" type="text" id="name" name="name" placeholder="Name">
                        </div>
                    </div>
                    <div class="form__row">
                        <div class="form__field">
                            <label class="form__label" for="company_name">Company Name</label>
                            <input class="form__input" type="text" id="company_name" name="company_name" placeholder="Company Name" required>
                        </div>
                    </div>
                    <div class="form__row">
                        <div class="form__field">
                            <label class="form__label" for="address">Address</label>
                            <input class="form__input" type="text" id="address" name="address" placeholder="Address">
                        </div>
                    </div>
                    <div class="form__row">
                        <div class="form__field">
                            <label class="form__label" for="post_code">Post code</label>
                            <input class="form__input" type="text" id="post_code" name="post_code" placeholder="Post code">
                        </div>
                    </div>
                    <div class="form__row">
                        <div class="form__field">
                            <label class="form__label" for="city">City</label>
                            <input class="form__input" type="text" id="city" name="city" placeholder="City">
                        </div>
                    </div>
                    <div class="form__row">
                        <div class="form__field">
                            <label class="form__label" for="phone">Phone</label>
                            <input class="form__input" type="text" id="phone" name="phone" placeholder="Phone">
                        </div>
                    </div>
                    <div class="form__row">
                        <div class="form__field">
                            <label class="form__label" for="siret">Siret</label>
                            <input class="form__input" type="text" id="siret" name="siret" placeholder="Siret">
                        </div>
                    </div>
                    <div class="form__row">
                        <div class="form__field">
                            <label class="form__label" for="rcs">RCS</label>
                            <input class="form__input" type="text" id="rcs" name="rcs" placeholder="RCS">
                        </div>
                    </div>
                    <div class="form__row">
                        <div class="form__field">
                            <label class="form__label" for="tva">TVA</label>
                            <input class="form__input" type="text" id="tva" name="tva" placeholder="TVA">
                        </div>
                    </div>
                    <div class="form__row">
                        <div class="form__field">
                            <label class="form__label" for="note">Note</label>
                            <input class="form__input" type="textarea" id="note" name="note" placeholder="Note">
                        </div>
                    </div>
                    <div class="form__submit-wrap">
                        <button class="form__submit btn" type="submit">Add</button>
                    </div>
                </div> -->
            </form>

            <!-- <div class="form-message title" v-if="form_sent">User created successfully</div> -->
        </div>
    </main>
</template>

<script>
export default {
    name: 'AddCompany',
    data: () => ({
        validate: {},
        formMessage: {
            class: '',
            message: '',
        }
    }),
    // mounted() {
    //     this.loadPageData();
    // },
    methods: {
        actionAddCompany() {
            const formData = new FormData(this.$refs['form']);
            const form_data = new FormData();

            for (let [key, val] of formData.entries()) {
                form_data.append(key, val)
            }

            axios({
                method: 'post',
                url: '/api/actionAddCompany', 
                data: form_data,
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
            );
        },
    }
}
</script>
