<template>
    <main class="edit-invoice-main">
        <div class="edit-invoice-main__wrapper wrapper">
            <h1 class="edit-invoice-main__title title title_center">Edit invoice</h1>
            <a :href="'/pdf/preview/' + invoice.id" class="btn" target="_blank">Priview PDF</a>
            <a :href="'/pdf/generate/' + invoice.id" class="btn" target="_blank">Download PDF</a>
            <form class="users-list-main__form form"  ref="form" @submit.prevent="onFormSubmit">
                <input type="hidden" name="id" :value="invoice.id">
                <div class="form__row">
                    <div class="form__field">
                        <label class="form__label" for="invoice_number">Invoice №</label>
                        <input id="invoice_number" type="text" name="invoice_number" :value="invoice.invoice_number">
                    </div>
                </div>

                <div class="form__row">
                    <div class="form__field">
                        <label class="form__label" for="received_date">Received date</label>
                        <input id="received_date" type="date" name="received_date" :value="invoice.received_date">
                    </div>
                </div>



                <div class="form__row">
                    <div class="form__field">
                        <label class="form__label" for="invoice_number">Photo</label>
                        <input id="invoice_number" type="text" name="invoice_number" :value="invoice.invoice_number">
                    </div>
                </div>
                <div class="form__row">
                    <div class="form__field">
                        <label class="form__label" for="invoice_number">Photo</label>
                        <input id="invoice_number" type="text" name="invoice_number" :value="invoice.invoice_number">
                    </div>
                </div>
                <div class="form__row">
                    <div class="form__field">
                        <label class="form__label" for="invoice_number">Photo</label>
                        <input id="invoice_number" type="text" name="invoice_number" :value="invoice.invoice_number">
                    </div>
                </div>
                <div class="form__row">
                    <div class="form__field">
                        <label class="form__label" for="invoice_number">Photo</label>
                        <input id="invoice_number" type="text" name="invoice_number" :value="invoice.invoice_number">
                    </div>
                </div>



            </form>
        </div>
    </main>
</template>

<script>
export default {
    name: 'EditInvoice',
    data: () => ({
        invoice: [],
    }),
    mounted() {
        this.getInvoice(this.$route.params.id);
    },
    methods: {
        getInvoice(id) {
            axios({
                method: 'get',
                url: '/api/getInvoice/' + id,
            }).then(
                res => {
                    if (res.data.status === 'success') {
                        this.invoice = res.data.invoice
                    }
                    
                }
            )
        },
        addInvoice() {
            axios({
               method: 'post',
               url: '/api/actionAddInvoice',
               data: {},
            }).then(
                res => {
                    if (res.data.status === 'success') {
                        this.$router.push('/');
                    }
                    if (res.data.status === 'error') {
                        this.errorMessage = res.data.message
                    }
                }
            )
        },
        onFormSubmit() {

        }
    }
}
</script>
