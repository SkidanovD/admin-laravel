<template>
    <main class="site-main company-main">
        <div class="site-main-wrapper company-main-wrapper width-container">
            <div :class="'text message message-' + formMessage.class" v-if="formMessage.message">{{ formMessage.message }}</div>
            <div class="return-button-block" v-if="returnButton">
                <div class="button-wrapper">
                    <div class="button-hover">
                        <router-link :to="'/companies-list'"  class="button">Back to company list</router-link>
                    </div>
                </div>
            </div>
            <div class="company-content" v-if="company.id">
                <h1 class="page-title company-page-title">{{ company.company_name }}</h1>
                <div class="company-main-info">
                    <div class="left-column">
                        <div class="image-wrapper">
                            <svg data-name="Layer 3" id="Layer_3" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                <line class="cls-1" style="stroke-linecap:round;stroke-linejoin:round;stroke-width:2px;" fill="none" stroke="#06ffff" x1="6" x2="26" y1="26" y2="26"/>
                                <rect class="cls-1" style="stroke-linecap:round;stroke-linejoin:round;stroke-width:2px;" fill="none" stroke="#06ffff" height="16" width="10" x="14" y="10"/>
                                <rect class="cls-1" style="stroke-linecap:round;stroke-linejoin:round;stroke-width:2px;" fill="none" stroke="#06ffff" height="13" width="6" x="8" y="13"/>
                                <rect class="cls-2" fill="#06ffff" height="13" width="2" x="12" y="13"/>
                                <line class="cls-3" style="stroke-miterlimit:10;" fill="none" stroke="#06ffff" x1="11" x2="11" y1="13" y2="26"/>
                                <line class="cls-4" style="stroke-linecap:round;stroke-miterlimit:10;" fill="none" stroke="#06ffff" x1="15" x2="21" y1="13.5" y2="13.5"/>
                                <line class="cls-4" style="stroke-linecap:round;stroke-miterlimit:10;" fill="none" stroke="#06ffff" x1="15" x2="21" y1="16.5" y2="16.5"/>
                                <line class="cls-4" style="stroke-linecap:round;stroke-miterlimit:10;" fill="none" stroke="#06ffff" x1="15" x2="21" y1="19.5" y2="19.5"/>
                                <rect class="cls-1" style="stroke-linecap:round;stroke-linejoin:round;stroke-width:2px;" fill="none" stroke="#06ffff" height="3" width="6" x="16" y="7"/>
                                <line class="cls-1" style="stroke-linecap:round;stroke-linejoin:round;stroke-width:2px;" fill="none" stroke="#06ffff" x1="19" x2="19" y1="7" y2="5"/>
                            </svg>
                        </div>
                    </div>
                    <div class="right-column">
                        <div class="block-info-item company-info-item" v-if="company.name">
                            <div class="block-info-label company-info-label">Name</div>
                            <div class="block-info-value company-info-value company-info-name h3">{{ company.name }}</div>
                        </div>
                        <div class="block-info-item company-info-item" v-if="company.address">
                            <div class="block-info-label company-info-label">Address</div>
                            <div class="block-info-value company-info-value company-info-address h5">{{ company.address }}, <br>{{ company.city }}, {{ company.post_code }}</div>
                        </div>
                        <div class="block-info-item company-info-item" v-if="company.phone">
                            <div class="block-info-label company-info-label">Telephone</div>
                            <div class="block-info-value company-info-value company-info-phone h4">{{ company.phone }}</div>
                        </div>
                        <div class="block-info-item company-info-item" v-if="company.rcs">
                            <div class="block-info-label company-info-label">RCS</div>
                            <div class="block-info-value company-info-value company-info-rcs h5">{{ company.rcs }}</div>
                        </div>
                        <div class="block-info-item company-info-item" v-if="company.siret">
                            <div class="block-info-label company-info-label">Siret</div>
                            <div class="block-info-value company-info-value company-info-siret h5">{{ company.siret }}</div>
                        </div>
                        <div class="block-info-item company-info-item" v-if="company.tva">
                            <div class="block-info-label company-info-label">TVA</div>
                            <div class="block-info-value company-info-value company-info-tva h5">{{ company.tva }}</div>
                        </div>
                        <div class="block-info-item company-info-item" v-if="company.note">
                            <div class="block-info-label company-info-label">Note</div>
                            <div class="block-info-value company-info-value company-info-note h5">{{ company.note }}</div>
                        </div>
                    </div>
                </div>
                <div class="company-button-block">
                    <div class="button-wrapper">
                        <div class="button-hover">
                            <button type="button" @click="actionCompanyDeletePopup(company.id)" class="button">Delete company</button>
                        </div>
                    </div>
                    <div class="button-wrapper">
                        <div class="button-hover">
                            <router-link :to="'/edit-company/' + company.id" class="button">Edit company</router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <vueDeletePopup v-if="displayDeletePopup" :deletePopupData="deletePopupData" @eventDeleteCompany="actionDeleteCompany(deletePopupData.itemId)" @eventHideDeletePopup="actionDisplayDeletePopup"></vueDeletePopup>
    </main>
</template>
<script>
    import vueValidateMessage from './../../components/MessageValidate';
    import vueDeletePopup from './../../components/DeletePopup';
    export default {
        name: 'Company',
        components: {
            vueValidateMessage,
            vueDeletePopup,
        },
        data: () => ({
            company: [],
            displayDeletePopup: false,
            deletePopupData: {
                textPopup: '',
                eventName: '',
                itemId: 0,
            },
            formMessage: {
                class: '',
                message: '',
            },
            returnButton: false,
        }),
        mounted() {
            this.getCompany(this.$route.params.id);
        },
        methods: {
            getCompany(id) {
                axios.get('/api/getCompany/' + id).then(res => {
                    if (res.data.status === 'success') {
                        this.company = res.data.company
                    } else {
                        this.formMessage.class = res.data.status;
                        this.formMessage.message = res.data.message;
                        this.scrollToElement();
                    }
                });
            },
            actionDeleteCompany() {
                axios({
                    method: 'post',
                    url: '/api/actionDeleteCompany',
                    data: {
                        id: this.company.id,
                    },
                }).then(res => {
                        this.actionDisplayDeletePopup();
                    if (res.data.status === 'success') {
                        this.company = [];
                        this.returnButton = true;
                    }
                    this.formMessage.class = res.data.status;
                    this.formMessage.message = res.data.message;
                    this.scrollToElement();
                })
            },
            actionDisplayDeletePopup() {
                if (this.displayDeletePopup) {
                    this.displayDeletePopup = false;
                    this.deletePopupData = {
                        textPopup: '',
                        eventName: '',
                        itemId: 0,
                    }
                } else {
                    this.displayDeletePopup = true;
                }
            },
            actionCompanyDeletePopup(id) {
                this.deletePopupData.textPopup = 'Are you sure you want to delete the company?';
                this.deletePopupData.eventName = 'eventDeleteCompany';
                this.deletePopupData.itemId = id;
                this.actionDisplayDeletePopup();
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
