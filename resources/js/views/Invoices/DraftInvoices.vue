<template>
    <main class="site-main draft-main">
        <div class="site-main-wrapper draft-main-wrapper width-container">
            <h1 class="page-title draft-page-title">Draft invoices</h1>
            <div :class="'text message message-' + formMessage.class" v-if="formMessage.message">{{ formMessage.message }}</div>
            <div class="no-invoices">
                <div class="text message message-info" v-if="getInvoices && !invoicesList.length">No invoice has been created yet.</div>
                <div class="button-wrapper">
                    <div class="button-hover">
                        <router-link to="/" class="button">Home</router-link>
                    </div>
                </div>
            </div>
            <div class="invoices-list" v-if="getInvoices && invoicesList.length">
                <div class="invoice-row invoice-row-header">
                    <div class="invoice-cell invoice-cell-header invoice-cell-number">#</div>
                    <div class="invoice-cell invoice-cell-header invoice-cell-date">Invoice date</div>
                    <div class="invoice-cell invoice-cell-header invoice-cell-company">Company</div>
                    <div class="invoice-cell invoice-cell-header invoice-cell-author">Author</div>
                    <div class="invoice-cell invoice-cell-header invoice-cell-total">Total</div>
                    <div class="invoice-cell invoice-cell-header invoice-cell-received-date">Received date</div>
                    <div class="invoice-cell invoice-cell-header invoice-cell-status">Status</div>
                    <div class="invoice-cell invoice-cell-header invoice-cell-action">
                        <div class="cell-icon cell-icon-links">
                            <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.26 13a2 2 0 0 1 .01-2.01A3 3 0 0 0 9 5H5a3 3 0 0 0 0 6h.08a6.06 6.06 0 0 0 0 2H5A5 5 0 0 1 5 3h4a5 5 0 0 1 .26 10zm1.48-6a2 2 0 0 1-.01 2.01A3 3 0 0 0 11 15h4a3 3 0 0 0 0-6h-.08a6.06 6.06 0 0 0 0-2H15a5 5 0 0 1 0 10h-4a5 5 0 0 1-.26-10z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="invoice-row" v-for="(invoice, index) in invoicesList" :key="index">
                    <div class="invoice-cell invoice-cell-number" :class="{empty: !invoice.invoice_number}">
                        <div class="invoice-cell-label">#</div>
                        <div class="invoice-cell-value">{{ invoice.invoice_number }}</div>
                    </div>
                    <div class="invoice-cell invoice-cell-date" :class="{empty: !invoice.invoice_date}">
                        <div class="invoice-cell-label">Invoice date</div>
                        <div class="invoice-cell-value">{{ invoice.invoice_date }}</div>
                    </div>
                    <div class="invoice-cell invoice-cell-company" :class="{empty: !invoice.company}">
                        <div class="invoice-cell-label">Company</div>
                        <div class="invoice-cell-value">{{ invoice.company }}</div>
                    </div>
                    <div class="invoice-cell invoice-cell-author" :class="{empty: !invoice.author.first_name}">
                        <div class="invoice-cell-label">Author</div>
                        <div class="invoice-cell-value">{{ invoice.author.first_name }}</div>
                    </div>
                    <div class="invoice-cell invoice-cell-total" :class="{empty: !invoice.total_tax}">
                        <div class="invoice-cell-label">Total</div>
                        <div class="invoice-cell-value">{{ invoice.total_tax }}</div>
                    </div>
                    <div class="invoice-cell invoice-cell-received-date" :class="{empty: !invoice.received_date}">
                        <div class="invoice-cell-label">Received date</div>
                        <div class="invoice-cell-value">{{ invoice.received_date }}</div>
                    </div>
                    <div class="invoice-cell invoice-cell-status" :class="{empty: !invoice.status}">
                        <div class="invoice-cell-label">Status</div>
                        <div class="invoice-cell-value"><span v-if="invoice.status">{{ invoice.status.replace(/_/g, ' ') }}</span></div>
                    </div>
                    <div class="invoice-cell invoice-cell-action">
                        <div class="btn-wrapper btn-edit-wrapper">
                            <button @click="showActionList(index)" class="btn btn-edit">
                                <svg style="enable-background:new 0 0 24 24;" version="1.1" viewBox="0 0 24 24" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g id="info"/>
                                    <g id="icons">
                                        <g id="menu">
                                            <path d="M20,10H4c-1.1,0-2,0.9-2,2c0,1.1,0.9,2,2,2h16c1.1,0,2-0.9,2-2C22,10.9,21.1,10,20,10z" fill="#676767" />
                                            <path d="M4,8h12c1.1,0,2-0.9,2-2c0-1.1-0.9-2-2-2H4C2.9,4,2,4.9,2,6C2,7.1,2.9,8,4,8z" fill="#676767"/>
                                            <path d="M16,16H4c-1.1,0-2,0.9-2,2c0,1.1,0.9,2,2,2h12c1.1,0,2-0.9,2-2C18,16.9,17.1,16,16,16z" fill="#676767"/>
                                        </g>
                                    </g>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="invoice-action-list" v-if="actionListShow === index" @click="showActionList">
                        <router-link :to="'/edit-invoice/' + invoice.id" class="invoice-action-item">Edit invoice</router-link>
                        <span @click="actionInvoiceDeletePopup(invoice.id)" class="invoice-action-item">Delete invoice</span>
                    </div>
                </div>
            </div>
        </div>
        <vueDeletePopup v-if="displayDeletePopup" :deletePopupData="deletePopupData" @eventDeleteInvoice="actionDeleteInvoice(deletePopupData.itemId)" @eventHideDeletePopup="actionDisplayDeletePopup"></vueDeletePopup>
    </main>
</template>
<script>
    import vueValidateMessage from './../../components/MessageValidate';
    import vueDeletePopup from './../../components/DeletePopup';
    export default {
        name: 'DraftInvoices',
        components: {
            vueValidateMessage,
            vueDeletePopup,
        },
        data: () => ({
            invoicesList: [],
            getInvoices: false,
            actionListShow: -1,
            indexListShow: -1,
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
        }),
        mounted() {
            this.unAuthenticated();
            this.loadPageData();
        },
        methods: {
            unAuthenticated() {
                axios.get('/api/unAuthenticated').catch(err => {
                    location = '/login';
                })
            },
            loadPageData() {
                axios.get('/api/getDraftInvoices').then(res => {
                    this.getInvoices = true;
                    if (res.data.status === 'success') {
                        this.invoicesList = res.data.all_invoices
                    } else {
                        this.invoicesList = [];
                        this.formMessage.class = res.data.status;
                        this.formMessage.message = res.data.message;
                        this.scrollToElement();
                    }
                })
            },
            showActionList(index) {
                if (this.actionListShow < 0) {
                    this.actionListShow = index;
                } else {
                    this.actionListShow = -1;
                }
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
            actionInvoiceDeletePopup(id) {
                this.deletePopupData.textPopup = 'Are you sure you want to delete the invoice?';
                this.deletePopupData.eventName = 'eventDeleteInvoice';
                this.deletePopupData.itemId = id;
                this.actionDisplayDeletePopup();
            },
            actionDeleteInvoice(id) {
                axios({
                    method: 'post',
                    url: '/api/actionDeleteInvoice',
                    data: {
                        id: id,
                    },
                }).then(
                    res => {
                        this.actionDisplayDeletePopup();
                        this.formMessage.class = res.data.status;
                        this.formMessage.message = res.data.message;
                        this.loadPageData();
                        this.scrollToElement();
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
