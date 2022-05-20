<template>
    <main class="site-main home-main">
        <div class="site-main-wrapper home-main-wrapper width-container">
            <h1 class="page-title home-page-title">Invoice generator</h1>
            <div v-if="getInvoices && invoicesList.length">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Invoice №</th>
                            <th>Invoice data</th>
                            <th>Author</th>
                            <th>Receiver</th>
                            <th>Total</th>
                            <th>Receive data</th>
                            <th>Status</th>
                            <th>Edit link</th>
                            <th>Delete link</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(invoice, index) in invoicesList" :key="index">
                            <td>{{ invoice.invoice_number }}</td>
                            <td>{{ invoice.invoice_date }}</td>
                            <td>{{ invoice.author.first_name }} {{ invoice.author.last_name }}</td>
                            <td>{{ invoice.company }}</td>

                            <td>{{ invoice.total_tax }}</td>

                            <td>{{ invoice.received_date }}</td>
                            <td>{{ invoice.status }}</td>
                            <td>
                                <router-link :to="'/edit-invoice/'+invoice.id">Edit invoice</router-link>
                            </td>
                            <td>
                                <a href="#" @click.prevent="deleteInvoice" :data-id="invoice.id">Delete invoice</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="no-invoices" v-if="getInvoices && !invoicesList.length">
                <div class="text message message-info">No invoice has been created yet. In order to create the first invoice, click the «Add invoice» button or check the list of unpublished invoices by clicking the «Draft» button.</div>
                <div class="button-wrapper">
                    <div class="button-hover">
                        <router-link to="/add-invoice" class="button">Add invoice</router-link>
                    </div>
                    <div class="button-hover">
                        <router-link to="#" class="button">Draft</router-link>
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
            getInvoices: false
        }),
        mounted() {
            this.loadPageData();
        },
        methods: {
            loadPageData() {
                axios.get('/api/getAllInvoices').then(res => {
                    this.getInvoices = true;
                    if (res.data.status === 'success') {
                        this.invoicesList = res.data.all_invoices
                    }
                })
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
