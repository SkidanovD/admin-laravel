<template>
    <main class="add-company-main">
        <div class="add-company-main__wrapper wrapper">
            <h1 class="add-company-main__title title title_center">New company page</h1>
            <form ref="form" class="form" @submit.prevent="onFormSubmit">
                <!-- <input class="form__input" type="hidden" name="_token" :value="pageData.csrf_token"> -->
                <div class="form__row">
                    <div class="form__field">
                        <label class="form__label" for="name">Name</label>
                        <input class="form__input" type="text" id="name" name="name" placeholder="Name">
                    </div>
                </div>
                <div class="form__row">
                    <div class="form__field">
                        <label class="form__label" for="company_name">Company Name</label>
                        <input class="form__input" type="text" id="company_name" name="company_name" placeholder="Company Name" required>
                    </div>
                </div>
                <div class="form__row">
                    <div class="form__field">
                        <label class="form__label" for="address">Address</label>
                        <input class="form__input" type="text" id="address" name="address" placeholder="Address">
                    </div>
                </div>
                <div class="form__row">
                    <div class="form__field">
                        <label class="form__label" for="post_code">Post code</label>
                        <input class="form__input" type="text" id="post_code" name="post_code" placeholder="Post code">
                    </div>
                </div>
                <div class="form__row">
                    <div class="form__field">
                        <label class="form__label" for="city">City</label>
                        <input class="form__input" type="text" id="city" name="city" placeholder="City">
                    </div>
                </div>
                <div class="form__row">
                    <div class="form__field">
                        <label class="form__label" for="phone">Phone</label>
                        <input class="form__input" type="text" id="phone" name="phone" placeholder="Phone">
                    </div>
                </div>
                <div class="form__row">
                    <div class="form__field">
                        <label class="form__label" for="siret">Siret</label>
                        <input class="form__input" type="text" id="siret" name="siret" placeholder="Siret">
                    </div>
                </div>
                <div class="form__row">
                    <div class="form__field">
                        <label class="form__label" for="rcs">RCS</label>
                        <input class="form__input" type="text" id="rcs" name="rcs" placeholder="RCS">
                    </div>
                </div>
                <div class="form__row">
                    <div class="form__field">
                        <label class="form__label" for="tva">TVA</label>
                        <input class="form__input" type="text" id="tva" name="tva" placeholder="TVA">
                    </div>
                </div>
                <div class="form__row">
                    <div class="form__field">
                        <label class="form__label" for="note">Note</label>
                        <input class="form__input" type="textarea" id="note" name="note" placeholder="Note">
                    </div>
                </div>
                <div class="form__submit-wrap">
                    <button class="form__submit btn" type="submit">Add</button>
                </div>
            </form>

            <!-- <div class="form-message title" v-if="form_sent">User created successfully</div> -->
        </div>
    </main>
</template>

<script>
export default {
    name: 'AddCompany',
    data: () => ({

    }),
    // mounted() {
    //     this.loadPageData();
    // },
    methods: {
        // loadPageData() {
        //     axios.get('/api/getPageRegister').then(res => {
        //         this.pageData = res.data
        //     })
        // },
        // onChange() {
        //     this.contacts.photo = this.$refs.form.photo.files[0];
        // },
        onFormSubmit() {      
            const formData = new FormData(this.$refs['form']);
            const form_data = new FormData();

            for (let [key, val] of formData.entries()) {
                form_data.append(key, val)
            }

            axios({
                method: 'post',
                url: '/api/actionAddCompany', 
                data: form_data,
            }).then(
                res => {
                    console.log(res.data);
                }
            )
        }
    }
}
</script>
