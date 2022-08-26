<template>
    <main class="site-main home-main">
        <div class="site-main-wrapper home-main-wrapper width-container">
            <h1 class="page-title home-page-title">Invoice generator</h1>
            <div :class="'text message message-' + formMessage.class" v-if="formMessage.message">{{ formMessage.message }}</div>
            <div class="no-invoices">
                <div class="text message message-info" v-if="getInvoices && !invoicesList.length && !Object.keys(filter).length">No invoice has been created yet. In order to create the first invoice, click the «Add invoice» button or check the list of unpublished invoices by clicking the «Draft» button.</div>
                <div class="button-wrapper">
                    <div class="button-hover">
                        <router-link to="/add-invoice" class="button">Add invoice</router-link>
                    </div>
                    <div class="button-hover">
                        <router-link to="/draft-invoices" class="button">Draft</router-link>
                    </div>
                </div>
            </div>
            <div class="invoices-list" v-if="getInvoices && invoicesList.length">
                <div class="invoice-row invoice-row-header">
                    <div class="invoice-cell invoice-cell-header invoice-cell-number sort-cell" :class="{asc: sort.orderBy === 'asc', desc: sort.orderBy === 'desc', active: sort.order === 'invoice_number'}" @click="actionSort('invoice_number')">#</div>
                    <div class="invoice-cell invoice-cell-header invoice-cell-date">Invoice date</div>
                    <div class="invoice-cell invoice-cell-header invoice-cell-company">Company</div>
                    <div class="invoice-cell invoice-cell-header invoice-cell-author">Author</div>
                    <div class="invoice-cell invoice-cell-header invoice-cell-total sort-cell" :class="{asc: sort.orderBy === 'asc', desc: sort.orderBy === 'desc', active: sort.order === 'total_tax'}" @click="actionSort('total_tax')">Total</div>
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
                    <div class="invoice-action-list" v-if="actionListShow === index" @click="hideActionList">
                        <router-link :to="'/edit-invoice/' + invoice.id" class="invoice-action-item">Edit invoice</router-link>
                        <span @click="showStatusPopup(index)" class="invoice-action-item">Edit status</span>
                        <span @click="showReceivedPopup(index)" class="invoice-action-item">Edit received date</span>
                        <a :href="'/pdf/preview/' + invoice.id" class="invoice-action-item" target="_blank">Priview PDF</a>
                        <a :href="'/pdf/generate/' + invoice.id" class="invoice-action-item" target="_blank">Download PDF</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="invoice-status-popup" v-if="statusPopupShow !== ''" @click="hideStatusPopup">
            <div class="invoice-status-popup-wrapper width-container">
                <div class="invoice-status-popup-list">
                    <div class="invoice-status-popup-item" v-if="statusPopupShow !== 'to_be_sent'" data-status="to_be_sent" @click="actionEditStatus('to_be_sent')">To be sent</div>
                    <div class="invoice-status-popup-item" v-if="statusPopupShow !== 'sent'" @click="actionEditStatus('sent')">Sent</div>
                    <div class="invoice-status-popup-item" v-if="statusPopupShow !== 'canceled'" @click="actionEditStatus('canceled')">Canceled</div>
                    <div class="invoice-status-popup-item" v-if="statusPopupShow !== 'paid'" @click="actionEditStatus('paid')">Paid</div>
                </div>
            </div>
        </div>
        <div class="invoice-received-popup" v-if="receivedPopupShow">
            <div class="invoice-received-popup-wrapper width-container">
                <div class="invoice-received-popup-block">
                    <div class="form-item-wrapper form-item-invoice-date-wrapper">
                        <div class="form-input-wrapper form-input-invoice-date-wrapper icon-date">
                            <input class="form-input form-input-invoice-date" id="invoice_date" name="invoice_date" type="date" placeholder="Received date" v-model="receivedDate">
                        </div>
                    </div>
                    <div class="buttons-block">
                        <div class="button-wrapper">
                            <div class="button-hover">
                                <button class="button" type="button" @click="hideReceivedPopup">Cancel</button>
                            </div>
                        </div>
                        <div class="button-wrapper">
                            <div class="button-hover">
                                <button class="button" type="button" @click="actionEditReceivedDate">Edit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="invoice-filter-block" :class="{show: filterShow}" v-if="Object.keys(filterData).length">
            <div class="invoice-filter-block-button" @click="showFilter">
                <div class="icon-wrapper">
                    <svg data-name="Layer 1" id="Layer_1" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                        <path d="M47,12a2,2,0,0,0-2-2H24a2,2,0,0,0,0,4H45A2,2,0,0,0,47,12Z" fill="#06ffff"/>
                        <path d="M3,14H8.35a6,6,0,1,0,0-4H3a2,2,0,0,0,0,4Zm11-4a2,2,0,1,1-2,2A2,2,0,0,1,14,10Z" fill="#06ffff"/>
                        <path d="M45,22H37.65a6,6,0,1,0,0,4H45a2,2,0,0,0,0-4ZM32,26a2,2,0,1,1,2-2A2,2,0,0,1,32,26Z" fill="#06ffff"/>
                        <path d="M22,22H3a2,2,0,0,0,0,4H22a2,2,0,0,0,0-4Z" fill="#06ffff"/>
                        <path d="M45,34H28a2,2,0,0,0,0,4H45a2,2,0,0,0,0-4Z" fill="#06ffff"/>
                        <path d="M18,30a6,6,0,0,0-5.65,4H3a2,2,0,0,0,0,4h9.35A6,6,0,1,0,18,30Zm0,8a2,2,0,1,1,2-2A2,2,0,0,1,18,38Z" fill="#06ffff"/>
                    </svg>
                </div>
            </div>
            <div class="invoice-filter-wrapper">
                <h2 class="h4 invoice-filter-block-title">Filter</h2>
                <div class="invoice-filter-item invoice-filter-item-companies" v-if="filterData.companies">
                    <h3 class="h5 invoice-filter-item-title">Companies :</h3>
                    <div class="invoice-filter-list">
                        <div class="invoice-filter-list-item invoice-filter-list-checkbox" v-for="(company, index) in filterData.companies" :key="index" @click="getFilterValue('company', company, $event)">
                            <div class="icon"></div>
                            <div class="label">{{ company }}</div>
                        </div>
                    </div>
                </div>
                <div class="invoice-filter-item invoice-filter-item-authors" v-if="filterData.authors">
                    <h3 class="h5 invoice-filter-item-title">Authors :</h3>
                    <div class="invoice-filter-list">
                        <div class="invoice-filter-list-item invoice-filter-list-checkbox" v-for="(author, index) in filterData.authors" :key="index" @click="getFilterValue('author', author.id, $event)">
                            <div class="icon"></div>
                            <div class="label">{{ author.label }}</div>
                        </div>
                    </div>
                </div>
                <div class="invoice-filter-item invoice-filter-item-authors" v-if="filterData.all_status">
                    <h3 class="h5 invoice-filter-item-title">Status :</h3>
                    <div class="invoice-filter-list">
                        <div class="invoice-filter-list-item invoice-filter-list-checkbox" v-for="(status, index) in filterData.all_status" :key="index" @click="getFilterValue('status', status, $event)">
                            <div class="icon"></div>
                            <div class="label">{{ status.replace(/_/g, ' ') }}</div>
                        </div>
                    </div>
                </div>
                <div class="invoice-filter-item invoice-filter-item-invoice-date">
                    <h3 class="h5 invoice-filter-item-title">Invoice date :</h3>
                    <div class="invoice-filter-list">
                        <div class="invoice-filter-list-item invoice-filter-list-invoice-date">
                            <div class="form-item-wrapper form-item-invoice-date-min-wrapper">
                                <div class="form-label-wrapper">
                                    <label for="invoice_date_min" class="form-label form-label-invoice-date-min">From</label>
                                </div>
                                <div class="form-input-wrapper form-input-invoice-date-min-wrapper icon-date">
                                    <input class="form-input form-input-invoice-date-min" id="invoice_date_min" type="date" v-model="filterInvoiceDateMin">
                                </div>
                            </div>
                            <div class="form-item-wrapper form-item-invoice-date-max-wrapper">
                                <div class="form-label-wrapper">
                                    <label for="invoice_date_max" class="form-label form-label-invoice-date-max">To</label>
                                </div>
                                <div class="form-input-wrapper form-input-invoice-date-max-wrapper icon-date">
                                    <input class="form-input form-input-invoice-date-max" id="invoice_date_max" type="date" v-model="filterInvoiceDateMax">
                                </div>
                            </div>
                        </div>
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
            statusPopupShow: '',
            statusPopupId: 0,
            receivedPopupShow: false,
            receivedPopupId: 0,
            receivedDate: '',
            filterShow: false,
            filterData: {},
            formMessage: {
                class: '',
                message: '',
            },
            sort: {
                order: 'invoice_number',
                orderBy: 'asc',
            },
            filterInvoiceDateMin: '',
            filterInvoiceDateMax: '',
            filter: {},
        }),
        mounted() {
            this.unAuthenticated();
            this.loadPageData();
            this.getFilterData();
        },
        watch: {
            filterInvoiceDateMin() {
                this.addInvoiceDateFilter();
            },
            filterInvoiceDateMax() {
                this.addInvoiceDateFilter();
            },
        },
        methods: {
            unAuthenticated() {
                axios.get('/api/unAuthenticated').catch(err => {
                    location = '/login';
                })
            },
            loadPageData() {
                axios({
                    method: 'post',
                    url: '/api/getAllInvoices',
                    data: {
                        sort: this.sort,
                        filter: this.filter,
                    },
                }).then(res => {
                    this.getInvoices = true;
                    this.formMessage = {
                        class: '',
                        message: '',
                    };
                    if (res.data.status === 'success') {
                        this.invoicesList = res.data.all_invoices
                    } else {
                        this.invoicesList = [];
                        if (Object.keys(this.filter).length) {
                            this.formMessage.class = res.data.status;
                            this.formMessage.message = res.data.message;
                        }
                    }
                })
            },
            getFilterData() {
                axios.get('/api/getFilterData').then(res => {
                    if (res.data.status === 'success') {
                        this.filterData = res.data.filter_data;
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
            hideActionList() {
                    this.actionListShow = -1;
            },
            showStatusPopup(index) {
                if (this.statusPopupShow === '') {
                    this.statusPopupShow = this.invoicesList[index].status;
                    this.statusPopupId = this.invoicesList[index].id;
                }
            },
            hideStatusPopup() {
                this.statusPopupShow = '';
            },
            actionEditStatus(status) {
                axios({
                    method: 'post',
                    url: '/api/actionEditStatus',
                    data: {
                        id: this.statusPopupId,
                        status: status,
                    },
                }).then(
                    res => {
                        this.formMessage.class = res.data.status;
                        this.formMessage.message = res.data.message;
                        if (res.data.status === 'success') {
                            this.loadPageData();
                        }
                    }
                )
            },
            showReceivedPopup(index) {
                this.receivedPopupShow = !this.receivedPopupShow;
                this.receivedPopupId = this.invoicesList[index].id;
            },
            hideReceivedPopup() {
                this.receivedPopupShow = !this.receivedPopupShow;
                this.receivedPopupId = 0;
            },
            actionEditReceivedDate() {
                if (this.receivedDate !== '') {
                    axios({
                        method: 'post',
                        url: '/api/actionEditReceivedDate',
                        data: {
                            id: this.receivedPopupId,
                            received_date: this.receivedDate,
                        },
                    }).then(
                        res => {
                            this.formMessage.class = res.data.status;
                            this.formMessage.message = res.data.message;
                            if (res.data.status === 'success') {
                                this.loadPageData();
                            }
                        }
                    )
                }
                this.receivedPopupShow = !this.receivedPopupShow;
                this.receivedPopupId = 0;
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
            },
            actionSort(field) {
                this.sort.order = field;
                if (this.sort.orderBy === 'asc') {
                    this.sort.orderBy = 'desc';
                } else {
                    this.sort.orderBy = 'asc';
                }
                this.loadPageData();
            },
            showFilter() {
                this.filterShow = !this.filterShow;
            },
            getFilterValue(key, value, event) {
                if (!event.target.classList.contains('selected')) {
                    event.target.classList.add('selected');
                    if (this.filter[key]) {
                        this.$set(this.filter[key], this.filter[key].length, value);
                        // this.filter[key].push(value);
                    } else {
                        this.$set(this.filter, key, [value]);
                    }
                } else {
                    event.target.classList.remove('selected');
                    var array_values = [];
                    for (var i = 0; i < this.filter[key].length; i++) {
                        if (this.filter[key][i] !== value) {
                            array_values.push(this.filter[key][i]);
                        }
                    }
                    this.filter[key] = array_values;
                    if (!this.filter[key].length) {
                        delete this.filter[key];
                    }
                }
                
                this.loadPageData();
            },
            addInvoiceDateFilter() {
                if (this.filterInvoiceDateMin === '' && this.filterInvoiceDateMax === '') {
                    delete this.filter.invoice_date;
                } else {
                    var date = {
                        min: this.filterInvoiceDateMin,
                        max: this.filterInvoiceDateMax,
                    }
                    this.$set(this.filter, 'invoice_date', date);
                }
                
                this.loadPageData();
            }
        }
    }
</script>
