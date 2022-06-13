<template>
    <main class="site-main edit-invoice-main">
        <div class="site-main-wrapper edit-invoice-main-wrapper width-container">
            <h1 class="page-title edit-company-page-title">Edit invoice</h1>
            <div :class="'text message message-' + formMessage.class" v-if="formMessage.message">{{ formMessage.message }}</div>
            <form class="users-list-main__form form"  ref="form" @submit.prevent="actionEditInvoice">
                <input id="id" type="hidden" name="id" :value="invoice.id">
                <div class="form-item-wrapper form-item-invoice-number-wrapper required">
                    <div class="form-input-wrapper form-input-invoice-number-wrapper icon-number">
                        <input class="form-input form-input-invoice-number" id="invoice_number" name="invoice_number" type="text" placeholder="Invoice number" v-model="invoice.invoice_number">
                    </div>
                    <vueValidateMessage  v-if="validate.invoice_number" :messages="validate.invoice_number"></vueValidateMessage>
                </div>
                <div class="form-item-wrapper form-item-invoice-date-wrapper required">
                    <div class="form-input-wrapper form-input-invoice-date-wrapper icon-date">
                        <input class="form-input form-input-invoice-date" id="invoice_date" name="invoice_date" type="date" placeholder="Invoice date" v-model="invoice.invoice_date">
                    </div>
                    <vueValidateMessage  v-if="validate.invoice_date" :messages="validate.invoice_date"></vueValidateMessage>
                </div>
                <div class="select-company-block">
                    <div class="label">
                        <div class="text">Click on this message to choose the company from the list.</div>
                        <div class="btn-wrapper btn-edit-wrapper" :class="{opened: companyListShow}">
                            <button type="button" class="btn btn-edit" @click="showCompanyList">
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
                    <div class="list" v-if="companyListShow">
                        <div v-for="(company, index) in companiesList" :key="index" :class="'item item-' + index" :data-index="index" @click="selectCompany(index)">{{ company.company_name }}</div>
                    </div>
                </div>
                <div class="form-item-wrapper form-item-name-wrapper" v-if="additionalFields">
                    <div class="form-input-wrapper form-input-name-wrapper icon-name">
                        <input class="form-input form-input-name" id="name" name="name" type="text" placeholder="Name" v-model="invoice.name">
                    </div>
                    <vueValidateMessage  v-if="validate.name" :messages="validate.name"></vueValidateMessage>
                </div>
                <div class="form-item-wrapper form-item-company-name-wrapper required">
                    <div class="form-input-wrapper form-input-company-name-wrapper icon-company">
                        <input class="form-input form-input-company-name" id="company_name" name="company_name" type="text" placeholder="Company name" v-model="invoice.company_name">
                    </div>
                    <vueValidateMessage  v-if="validate.company_name" :messages="validate.company_name"></vueValidateMessage>
                </div>
                <div class="form-item-wrapper form-item-address-wrapper">
                    <div class="form-input-wrapper form-input-address-wrapper icon-address">
                        <input class="form-input form-input-address" id="address" name="address" type="text" placeholder="Address" v-model="invoice.address">
                    </div>
                    <vueValidateMessage  v-if="validate.address" :messages="validate.address"></vueValidateMessage>
                </div>
                <div class="form-item-wrapper form-item-post-code-wrapper">
                    <div class="form-input-wrapper form-input-post-code-wrapper icon-post-code">
                        <input class="form-input form-input-post-code" id="post_code" name="post_code" type="text" placeholder="Post code" v-model="invoice.post_code">
                    </div>
                    <vueValidateMessage  v-if="validate.post_code" :messages="validate.post_code"></vueValidateMessage>
                </div>
                <div class="form-item-wrapper form-item-city-wrapper">
                    <div class="form-input-wrapper form-input-city-wrapper icon-city">
                        <input class="form-input form-input-city" id="city" name="city" type="text" placeholder="City" v-model="invoice.city">
                    </div>
                    <vueValidateMessage  v-if="validate.city" :messages="validate.city"></vueValidateMessage>
                </div>
                <div class="form-item-wrapper form-item-phone-wrapper" v-if="additionalFields">
                    <div class="form-input-wrapper form-input-phone-wrapper icon-phone">
                        <input class="form-input form-input-phone" id="phone" name="phone" type="text" placeholder="Telephone" v-model="invoice.phone">
                    </div>
                    <vueValidateMessage  v-if="validate.phone" :messages="validate.phone"></vueValidateMessage>
                </div>
                <div class="form-item-wrapper form-item-siret-wrapper" v-if="additionalFields">
                    <div class="form-input-wrapper form-input-siret-wrapper icon-barcode">
                        <input class="form-input form-input-siret" id="siret" name="siret" type="text" placeholder="Siret" v-model="invoice.siret">
                    </div>
                    <vueValidateMessage  v-if="validate.siret" :messages="validate.siret"></vueValidateMessage>
                </div>
                <div class="form-item-wrapper form-item-rcs-wrapper" v-if="additionalFields">
                    <div class="form-input-wrapper form-input-rcs-wrapper icon-barcode">
                        <input class="form-input form-input-rcs" id="rcs" name="rcs" type="text" placeholder="RCS" v-model="invoice.rcs">
                    </div>
                    <vueValidateMessage  v-if="validate.rcs" :messages="validate.rcs"></vueValidateMessage>
                </div>
                <div class="form-item-wrapper form-item-tva-wrapper">
                    <div class="form-input-wrapper form-input-tva-wrapper icon-barcode">
                        <input class="form-input form-input-tva" id="tva" name="tva" type="text" placeholder="TVA" v-model="invoice.tva">
                    </div>
                    <vueValidateMessage  v-if="validate.tva" :messages="validate.tva"></vueValidateMessage>
                </div>
                <div class="form-item-wrapper form-item-note-wrapper" v-if="additionalFields">
                    <div class="form-input-wrapper form-textarea-wrapper form-textarea-note-wrapper icon-note">
                        <textarea class="form-input form-textarea form-textarea-note" name="note" id="note" cols="30" rows="8" placeholder="Note" v-model="invoice.note"></textarea>
                    </div>
                    <vueValidateMessage  v-if="validate.note" :messages="validate.note"></vueValidateMessage>
                </div>
                <div class="company-all-fields">
                    <label for="company_all_fields_button" class="company-all-fields-label">Show additional company fields</label>
                    <button id="company_all_fields_button" type="button" class="switch-btn" :class="{active: additionalFields}" @click="showAdditionalFields"></button>
                </div>
                <div class="invoice-details-block">
                    <div class="invoice-detail-row invoice-detail-row-header">
                        <div class="invoice-detail-cell invoice-detail-cell-order invoice-detail-cell-header">#</div>
                        <div class="invoice-detail-cell invoice-detail-cell-description invoice-detail-cell-header">Description</div>
                        <div class="invoice-detail-cell invoice-detail-cell-quantity invoice-detail-cell-header">Qty</div>
                        <div class="invoice-detail-cell invoice-detail-cell-price invoice-detail-cell-header">Price</div>
                    </div>
                    <div class="invoice-detail-row-wrapper" v-for="(invoiceDetail, index) in invoiceDetails" :key="index">
                        <vueInvoiceDetail :invoiceDetail="invoiceDetail" :index="index" @eventDeleteInvoiceRow="deleteInvoiceRow" @eventTotalCalculation="totalCalculation"></vueInvoiceDetail>
                        <vueValidateMessage  v-if="validate['details.' + index + '.description']" :messages="validate['details.' + index + '.description']"></vueValidateMessage>
                        <vueValidateMessage  v-if="validate['details.' + index + '.price']" :messages="validate['details.' + index + '.price']"></vueValidateMessage>
                    </div>
                    <div class="button-wrapper">
                        <div class="button-hover">
                            <button type="button" class="button" @click="addDetailRow">Add detail</button>
                        </div>
                    </div>
                </div>
                <div class="invoice-total-block">
                    <div class="form-item-wrapper form-item-total-wrapper">
                        <div class="form-label-wrapper">
                            <label class="form-label form-label-total">Total, €</label>
                        </div>
                        <div class="form-input-wrapper form-input-total-wrapper icon-price">
                            <input class="form-input form-input-total" id="total" name="total" type="text" placeholder="Total, €" v-model="totalPrice" disabled>
                        </div>
                        <vueValidateMessage  v-if="validate.total" :messages="validate.total"></vueValidateMessage>
                    </div>
                    <div class="form-item-wrapper form-item-vat-wrapper">
                        <div class="form-label-wrapper">
                            <label class="form-label form-label-total">VAT, %</label>
                        </div>
                        <div class="form-input-wrapper form-input-vat-wrapper icon-vat">
                            <input class="form-input form-input-vat" id="vat" name="vat" type="text" placeholder="VAT, %" v-model="vat">
                            <div class="invoice-vat-quantity">( {{ vatQuantity }} € )</div>
                        </div>
                        <vueValidateMessage  v-if="validate.vat" :messages="validate.vat"></vueValidateMessage>
                    </div>
                    <div class="form-item-wrapper form-item-total-tax-wrapper">
                        <div class="form-label-wrapper">
                            <label class="form-label form-label-total">Total, € (all taxes incl.)</label>
                        </div>
                        <div class="form-input-wrapper form-input-total-tax-wrapper icon-price">
                            <input class="form-input form-input-total-tax" id="total_tax" name="total_tax" type="text" placeholder="Total, € (all taxes incl.)" v-model="totalTax" disabled>
                        </div>
                        <vueValidateMessage  v-if="validate.total_tax" :messages="validate.total_tax"></vueValidateMessage>
                    </div>
                </div>
                <div class="button-wrapper button-submit-wrapper">
                    <div class="button-hover button-submit-hover">
                        <button class="button button-submit" type="submit">Edit invoice</button>
                    </div>
                </div>
            </form>
            <div class="edit-invoice-buttons-block">
                <div class="button-wrapper">
                    <div class="button-hover">
                        <button type="button" class="button" @click="actionPublicInvoice">Public invoice</button>
                    </div>
                </div>
                <div class="button-wrapper">
                    <div class="button-hover">
                        <a :href="'/pdf/preview/' + invoice.id" class="button" target="_blank">Priview PDF</a>
                    </div>
                </div>
                <div class="button-wrapper">
                    <div class="button-hover">
                        <a :href="'/pdf/generate/' + invoice.id" class="button" target="_blank">Download PDF</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
    import vueValidateMessage from './../../components/MessageValidate';
    import vueInvoiceDetail from './../../components/InvoiceDetail';
    export default {
        name: 'EditInvoice',
        components: {
            vueValidateMessage,
            vueInvoiceDetail,
        },
        data: () => ({
            invoice: [],
            invoiceDetails: [
                {
                    order: 1,
                    description: '',
                    quantity: '',
                    price: '',
                }
            ],
            companiesList: [],
            companyListShow: false,
            totalPrice: 0,
            vat: '',
            vatQuantity: 0,
            totalTax: 0,
            validate: [],
            additionalFields: false,
            formMessage: {
                class: '',
                message: '',
            }
        }),
        mounted() {
            this.getInvoice(this.$route.params.id);
            this.getAllCompanies();
            var $this = this;
            setTimeout(function() {
                $this.totalCalculation();
            }, 1000);
        },
        watch: {
            totalPrice() {
                this.countTotalPrice();
            },
            vat() {
                this.countTotalPrice();
            },
        },
        methods: {
            getInvoice(id) {
                axios({
                    method: 'get',
                    url: '/api/getInvoice/' + id,
                }).then(
                    res => {
                        if (res.data.status === 'success') {
                            if (res.data.invoice.name || res.data.invoice.phone || res.data.invoice.siret || res.data.invoice.rcs || res.data.invoice.note) {
                                this.additionalFields = true;
                            }
                            this.invoice = res.data.invoice
                            if (res.data.invoice.details.length) {
                                this.invoiceDetails = res.data.invoice.details;
                            }
                            this.vat = String(res.data.invoice.vat);
                        } else {
                            this.formMessage.class = res.data.status;
                            this.formMessage.message = res.data.message;
                        }
                    }
                )
            },
            getAllCompanies() {
                axios.get('/api/getAllCompanies').then(res => {
                this.getAllCompanies = true;
                    if (res.data.status === 'success') {
                        this.companiesList = res.data.all_companies;
                    }
                });
            },
            addDetailRow() {
                var newRow = {
                        order: this.invoiceDetails.length + 1,
                        description: '',
                        quantity: '',
                        price: '',
                    };
                this.invoiceDetails.push(newRow);
            },
            deleteInvoiceRow(index) {
                delete this.invoiceDetails[index];
                var count = 0;
                this.invoiceDetails.forEach(function(elem, idx, arrray) {
                    elem.order = count + 1;
                    elem.description = document.getElementById('description_' + idx).value;
                    elem.quantity = document.getElementById('quantity_' + idx).value;
                    elem.price = document.getElementById('price_' + idx).value;
                    count++;
                    
                });
                this.invoiceDetails = this.invoiceDetails.filter((_, index) => this.invoiceDetails.hasOwnProperty(index));
                var $this = this;
                setTimeout(function() {
                    $this.totalCalculation();
                }, 1000);
            },
            totalCalculation() {
                var elements = document.querySelectorAll('input[id*="price_"]'),
                    summary = 0;
                elements.forEach(function(elem) {
                    var price = elem.value.replace(',', '.');
                    if (!price) {
                        price = 0;
                    }
                    summary += parseFloat(price);
                });
                
                this.totalPrice = summary.toFixed(2);
            },
            countTotalPrice() {
                var vat = parseFloat(this.vat.replace(',', '.'));
                this.vatQuantity = (this.totalPrice * (vat / 100)).toFixed(2)
                this.totalTax = (this.totalPrice * (1 + vat / 100)).toFixed(2);
            },
            showAdditionalFields() {
                this.additionalFields = !this.additionalFields;
            },
            showCompanyList() {
                this.companyListShow = !this.companyListShow;
            },
            selectCompany(index) {
                var company = this.companiesList[index];
                if (company.name || company.note || company.phone || company.rcs || company.siret) {
                    this.additionalFields = true;
                }
                this.invoice.name = company.name;
                this.invoice.company_name = company.company_name;
                this.invoice.address = company.address;
                this.invoice.post_code = company.post_code;
                this.invoice.city = company.city;
                this.invoice.phone = company.phone;
                this.invoice.siret = company.siret;
                this.invoice.rcs = company.rcs;
                this.invoice.siret = company.siret;
                this.invoice.tva = company.tva;
                this.invoice.note = company.note;


                this.companyListShow = false;
                
            },
            actionEditInvoice() {
                const formData = new FormData(this.$refs['form']);
                const form_data = new FormData();

                for (let [key, val] of formData.entries()) {
                    form_data.append(key, val)
                }
                form_data.append('total_tax', this.totalTax);

                axios({
                    method: 'post',
                    url: '/api/actionEditInvoice',
                    data: form_data,
                }).then(
                    res => {
                        if (res.data.status === 'not validated') {
                            for(let key in res.data.messages) {
                                this.$set(this.validate, key, res.data.messages[key]);
                            }
                            this.invoice = res.data.form_field;
                        } else {
                            this.validate = [];
                            this.formMessage.class = res.data.status;
                            this.formMessage.message = res.data.message;
                            this.getInvoice(this.$route.params.id);
                        }
                    }
                )
            },
            actionPublicInvoice() {
                const formData = new FormData(this.$refs['form']);
                const form_data = new FormData();

                for (let [key, val] of formData.entries()) {
                    form_data.append(key, val)
                }
                form_data.append('total_tax', this.totalTax);

                axios({
                    method: 'post',
                    url: '/api/actionEditInvoice',
                    data: form_data,
                }).then(
                    res => {
                        if (res.data.status === 'not validated') {
                            for(let key in res.data.messages) {
                                this.$set(this.validate, key, res.data.messages[key]);
                            }
                            this.invoice = res.data.form_field;
                        } else {
                            var invoice = res.data.invoice;
                            axios({
                                method: 'post',
                                url: '/api/actionPublicInvoice',
                                data: invoice,
                            }).then(
                                res => {
                                    if (res.data.status === 'success') {
                                        this.validate = [];
                                        this.formMessage.class = res.data.status;
                                        this.formMessage.message = res.data.message;
                                        this.getInvoice(this.$route.params.id);
                                    } else {
                                        this.formMessage.class = res.data.status;
                                        this.formMessage.message = res.data.message;
                                    }
                                }
                            )
                        }
                    }
                )
            },
        }
    }
</script>
