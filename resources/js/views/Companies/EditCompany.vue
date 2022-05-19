<template>
<main class="edit-company-main">
    <div class="edit-company-main__wrapper wrapper">
        <h1 class="edit-company-main__title title title_center">Edit user</h1>

        <form class="edit-company-main__form form"  ref="form" @submit.prevent="onFormSubmit">
            <input id="id" type="hidden" name="id" :value="company.id">
            <div class="form__row">
                <div class="form__field">
                    <label class="form__label" for="name">Name</label>
                    <input class="form__input" type="text" id="name" name="name" placeholder="Name" :value="company.name">
                </div>
            </div>
                <div class="form__row">
                    <div class="form__field">
                        <label class="form__label" for="company_name">Company Name</label>
                        <input class="form__input" type="text" id="company_name" name="company_name" placeholder="Company Name" :value="company.company_name" required>
                    </div>
                </div>
                <div class="form__row">
                    <div class="form__field">
                        <label class="form__label" for="address">Address</label>
                        <input class="form__input" type="text" id="address" name="address" placeholder="Address" :value="company.address">
                    </div>
                </div>
                <div class="form__row">
                    <div class="form__field">
                        <label class="form__label" for="post_code">Post code</label>
                        <input class="form__input" type="text" id="post_code" name="post_code" placeholder="Post code" :value="company.post_code">
                    </div>
                </div>
                <div class="form__row">
                    <div class="form__field">
                        <label class="form__label" for="city">City</label>
                        <input class="form__input" type="text" id="city" name="city" placeholder="City" :value="company.city">
                    </div>
                </div>
                <div class="form__row">
                    <div class="form__field">
                        <label class="form__label" for="phone">Phone</label>
                        <input class="form__input" type="text" id="phone" name="phone" placeholder="Phone" :value="company.phone">
                    </div>
                </div>
                <div class="form__row">
                    <div class="form__field">
                        <label class="form__label" for="siret">Siret</label>
                        <input class="form__input" type="text" id="siret" name="siret" placeholder="Siret" :value="company.siret">
                    </div>
                </div>
                <div class="form__row">
                    <div class="form__field">
                        <label class="form__label" for="rcs">RCS</label>
                        <input class="form__input" type="text" id="rcs" name="rcs" placeholder="RCS" :value="company.rcs">
                    </div>
                </div>
                <div class="form__row">
                    <div class="form__field">
                        <label class="form__label" for="tva">TVA</label>
                        <input class="form__input" type="text" id="tva" name="tva" placeholder="TVA" :value="company.tva">
                    </div>
                </div>
                <div class="form__row">
                    <div class="form__field">
                        <label class="form__label" for="note">Note</label>
                        <input class="form__input" type="textarea" id="note" name="note" placeholder="Note" :value="company.note">
                    </div>
                </div>
                <div class="form__submit-wrap">
                    <button class="form__submit btn" type="submit">Edit</button>
                </div>
        </form>
    </div>
</main>
</template>

<script>
export default {
    name: 'EditCompany',
    data: () => ({
        company: [],
    }),
    mounted() {
        this.loadCompany(this.$route.params.id);
    },
    methods: {
        loadCompany(id) {
            axios.get('/api/getCompany/' + id).then(res => {
                if (res.data.status === 'success') {
                    this.company = res.data.company;
                }
            })
        },
        onFormSubmit() {
            const formData = new FormData(this.$refs['form']);
            const form_data = new FormData();

            for (let [key, val] of formData.entries()) {
                form_data.append(key, val)
            }
            

            axios({
                method: 'post',
                url: '/api/actionEditUser',
                data: form_data,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(
                res => {
                    console.log(res.data);
                    
                    // if(res.data.status == 'success') {
                    //     this.form_sent = true
                    // } else {
                    //     for(let key in res.data.messages) {
                    //         this.messages[key] = res.data.messages[key][0];
                    //     }
                    // }
                }
            )
        }
    }
}
</script>
