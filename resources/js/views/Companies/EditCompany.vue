<template>
    <main class="site-main edit-company-main">
        <div class="site-main-wrapper edit-company-main-wrapper width-container">
            <h1 class="page-title edit-company-page-title">Edit company</h1>
            <div :class="'text message message-' + formMessage.class" v-if="formMessage.message">{{ formMessage.message }}</div>
            <form class="form register-form"  ref="form" @submit.prevent="actionEditCompany">
                <input id="id" type="hidden" name="id" :value="company.id">
                <div class="form-item-wrapper form-item-name-wrapper">
                    <div class="form-input-wrapper form-input-name-wrapper icon-name">
                        <input class="form-input form-input-name" id="name" name="name" type="text" placeholder="Name" :value="company.name">
                    </div>
                    <vueValidateMessage  v-if="validate.name" :messages="validate.name"></vueValidateMessage>
                </div>
                <div class="form-item-wrapper form-item-company-name-wrapper required">
                    <div class="form-input-wrapper form-input-company-name-wrapper icon-company">
                        <input class="form-input form-input-company-name" id="company_name" name="company_name" type="text" placeholder="Company name" :value="company.company_name">
                    </div>
                    <vueValidateMessage  v-if="validate.company_name" :messages="validate.company_name"></vueValidateMessage>
                </div>
                <div class="form-item-wrapper form-item-address-wrapper">
                    <div class="form-input-wrapper form-input-address-wrapper icon-address">
                        <input class="form-input form-input-address" id="address" name="address" type="text" placeholder="Address" :value="company.address">
                    </div>
                    <vueValidateMessage  v-if="validate.address" :messages="validate.address"></vueValidateMessage>
                </div>
                <div class="form-item-wrapper form-item-post-code-wrapper">
                    <div class="form-input-wrapper form-input-post-code-wrapper icon-post-code">
                        <input class="form-input form-input-post-code" id="post_code" name="post_code" type="text" placeholder="Post code" :value="company.post_code">
                    </div>
                    <vueValidateMessage  v-if="validate.post_code" :messages="validate.post_code"></vueValidateMessage>
                </div>
                <div class="form-item-wrapper form-item-city-wrapper">
                    <div class="form-input-wrapper form-input-city-wrapper icon-city">
                        <input class="form-input form-input-city" id="city" name="city" type="text" placeholder="City" :value="company.city">
                    </div>
                    <vueValidateMessage  v-if="validate.city" :messages="validate.city"></vueValidateMessage>
                </div>
                <div class="form-item-wrapper form-item-phone-wrapper">
                    <div class="form-input-wrapper form-input-phone-wrapper icon-phone">
                        <input class="form-input form-input-phone" id="phone" name="phone" type="text" placeholder="Telephone" :value="company.phone">
                    </div>
                    <vueValidateMessage  v-if="validate.phone" :messages="validate.phone"></vueValidateMessage>
                </div>
                <div class="form-item-wrapper form-item-siret-wrapper">
                    <div class="form-input-wrapper form-input-siret-wrapper icon-barcode">
                        <input class="form-input form-input-siret" id="siret" name="siret" type="text" placeholder="Siret" :value="company.siret">
                    </div>
                    <vueValidateMessage  v-if="validate.siret" :messages="validate.siret"></vueValidateMessage>
                </div>
                <div class="form-item-wrapper form-item-rcs-wrapper">
                    <div class="form-input-wrapper form-input-rcs-wrapper icon-barcode">
                        <input class="form-input form-input-rcs" id="rcs" name="rcs" type="text" placeholder="RCS" :value="company.rcs">
                    </div>
                    <vueValidateMessage  v-if="validate.rcs" :messages="validate.rcs"></vueValidateMessage>
                </div>
                <div class="form-item-wrapper form-item-tva-wrapper">
                    <div class="form-input-wrapper form-input-tva-wrapper icon-barcode">
                        <input class="form-input form-input-tva" id="tva" name="tva" type="text" placeholder="TVA" :value="company.tva">
                    </div>
                    <vueValidateMessage  v-if="validate.tva" :messages="validate.tva"></vueValidateMessage>
                </div>
                <div class="form-item-wrapper form-item-note-wrapper">
                    <div class="form-input-wrapper form-textarea-wrapper form-textarea-note-wrapper icon-note">
                        <textarea class="form-input form-textarea form-textarea-note" name="note" id="note" cols="30" rows="8" placeholder="Note" :value="company.note"></textarea>
                    </div>
                    <vueValidateMessage  v-if="validate.note" :messages="validate.note"></vueValidateMessage>
                </div>
                <div class="button-wrapper button-submit-wrapper">
                    <div class="button-hover button-submit-hover">
                        <button class="button button-submit" type="submit">Edit company</button>
                    </div>
                </div>
            </form>
        </div>
    </main>
</template>

<script>
    import vueValidateMessage from './../../components/MessageValidate';
    export default {
        name: 'EditCompany',
        components: {
            vueValidateMessage,
        },
        data: () => ({
            company: [],
            validate: {},
            formMessage: {
                class: '',
                message: '',
            }
        }),
        mounted() {
            this.getCompany(this.$route.params.id);
        },
        methods: {
            getCompany(id) {
                axios.get('/api/getCompany/' + id).then(res => {
                    if (res.data.status === 'success') {
                        this.company = res.data.company;
                    }
                })
            },
            actionEditCompany() {
                const formData = new FormData(this.$refs['form']);
                const form_data = new FormData();

                for (let [key, val] of formData.entries()) {
                    form_data.append(key, val)
                }
                

                axios({
                    method: 'post',
                    url: '/api/actionEditCompany',
                    data: form_data,
                }).then(
                    res => {
                        if (res.data.status === 'not validated') {
                            for(let key in res.data.messages) {
                                this.$set(this.validate, key, res.data.messages[key]);
                            }
                            this.company = res.data.form_field;
                        } else {
                            this.validate = [];
                            this.formMessage.class = res.data.status;
                            this.formMessage.message = res.data.message;
                            this.getCompany(this.$route.params.id)
                        }
                    }
                )
            },
        }
    }
</script>
