<template>
    <main class="site-main draft-main">
        <div class="site-main-wrapper draft-main-wrapper width-container">
            <h1 class="page-title draft-page-title">Draft invoices</h1>
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
                    <div class="invoice-cell invoice-cell-number" :class="{empty: !invoice.invoice_number}">{{ invoice.invoice_number }}</div>
                    <div class="invoice-cell invoice-cell-date" :class="{empty: !invoice.invoice_date}">{{ invoice.invoice_date }}</div>
                    <div class="invoice-cell invoice-cell-company" :class="{empty: !invoice.company}">{{ invoice.company }}</div>
                    <div class="invoice-cell invoice-cell-author" :class="{empty: !invoice.author.first_name}">{{ invoice.author.first_name }}</div>
                    <div class="invoice-cell invoice-cell-total" :class="{empty: !invoice.total_tax}">{{ invoice.total_tax }}</div>
                    <div class="invoice-cell invoice-cell-received-date" :class="{empty: !invoice.received_date}">{{ invoice.received_date }}</div>
                    <div class="invoice-cell invoice-cell-status" :class="{empty: !invoice.status}">
                        <span v-if="invoice.status">{{ invoice.status.replace(/_/g, ' ') }}</span>
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
                    <div class="invoice-action-list" v-if="actionListShow === index">
                        <router-link :to="'/edit-invoice/' + invoice.id" class="invoice-action-item">Edit invoice</router-link>
                    </div>
                </div>
            </div>
            <div class="no-invoices">
                <div class="text message message-info" v-if="getInvoices && !invoicesList.length">No invoice has been created yet.</div>
                <div class="button-wrapper">
                    <div class="button-hover">
                        <router-link to="/" class="button">Home</router-link>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
<script>
    export default {
        name: 'Index',
        data: () => ({
            invoicesList: [],
            getInvoices: false,
            actionListShow: -1,
            indexListShow: -1,
        }),
        mounted() {
            this.loadPageData();
        },
        methods: {
            loadPageData() {
                axios.get('/api/getDraftInvoices').then(res => {
                    this.getInvoices = true;
                    if (res.data.status === 'success') {
                        this.invoicesList = res.data.all_invoices
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
            deleteInvoice(e) {
                axios({
                    method: 'post',
                    url: '/api/actionDeleteInvoice',
                    data: {
                        id: e.target.dataset.id,
                    },
                }).then(
                    res => {
                        this.loadPageData();
                    }
                )
            }
        }
    }
</script>
