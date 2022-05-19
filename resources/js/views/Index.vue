<template>
    <main class="site-main home-main">
        <div class="home-main__wrapper wrapper">
            <h1 class="title">Homepage</h1>
            <div class="button-wrapper">
                <router-link to="/add-invoice" class="btn">Add invoice</router-link>
            </div>
            
            <div>
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
        </div>
    </main>
</template>
<script>
    export default {
        data: () => ({
            invoicesList: [],
        }),
        mounted() {
            this.loadPageData();
        },
        methods: {
            loadPageData() {
                axios.get('/api/getAllInvoices').then(res => {
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
