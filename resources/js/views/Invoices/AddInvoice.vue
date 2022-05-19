<template>
    <main class="add-invoice-main">
        <div class="add-invoice-main__wrapper wrapper">
            <h1 class="add-invoice-main__title title title_center">Edit invoice</h1>
            <div class="form-message title" v-if="errorMessage">
            
            </div>
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
