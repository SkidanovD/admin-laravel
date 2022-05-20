<template>
    <main class="site-main add-invoice-main">
        <div class="site-main-wrapper add-invoice-main-wrapper width-container">
            <h1 class="page-title add-invoice-page-title">Add invoice</h1>
            <div class="message message-error" v-if="errorMessage">{{errorMessage}}</div>
        </div>
    </main>
</template>

<script>
export default {
    name: 'AddInvoice',
    data: () => ({
        errorMessage: '',
    }),
    mounted() {
        this.addInvoice();
    },
    methods: {
        addInvoice(id) {
            axios({
               method: 'post',
               url: '/api/actionAddInvoice',
               data: {},
            }).then(
                res => {
                    if (res.data.status === 'success') {
                        this.$router.push('/edit-invoice/' + res.data.invoice.id);
                    }
                    if (res.data.status === 'error') {
                        this.errorMessage = res.data.message
                    }
                }
            )
        },
    }
}
</script>
