<template>
<main class="users-list-main">
    <div class="users-list-main__wrapper wrapper">
        <h1 class="users-list-main__title title title_center">Edit user</h1>

        <form class="users-list-main__form form" action="" method="POST">
            <input id="id" type="hidden" name="id" :value="user.id">

            <div class="form__row">
                <div class="form__field">
                    <select class="form__input" id="role" name="role" required>
                        <option v-for="(option, idx) in inputSelect" :key="idx" :value="option.value" :selected="option.selected">{{option.title}}</option>
                    </select>
                </div>
            </div>
            
            <div class="form__row">
                <div class="form__field">
                    <label class="form__label" for="photo">Photo</label>
                    <input id="photo" type="file" name="photo" :value="user.photo">
                </div>
            </div>

            <div class="form__row">
                <div class="form__field">
                    <label class="form__label" for="first_name">First Name</label>
                    <input class="form__input" type="text" id="first_name" name="first_name" placeholder="First name" :value="user.first_name">
                </div>
                <div class="form__field">
                    <label class="form__label" for="last_name">Last Name</label>
                    <input class="form__input" type="text" id="last_name" name="last_name" placeholder="Last name" :value="user.last_name">
                </div>
            </div>
            
            <div class="form__row">
                <div class="form__field">
                    <label class="form__label" for="user_post">User Post</label>
                    <input class="form__input" type="text" id="user_post" name="user_post" placeholder="User post" :value="user.user_post">
                </div>
            </div>

            <div class="form__row">
                <div class="form__field">
                    <label class="form__label" for="email">Email</label>
                    <input class="form__input" type="email" id="email" name="email" placeholder="Email" :value="user.email" required>
                </div>
            </div>

            
            
            <div class="form__row">
                <div class="form__field">
                    <label class="form__label" for="password">New password</label>
                    <input class="form__input" type="password" id="password" name="password" placeholder="* * * * * * * *" required>
                </div>

                <div class="form__field">
                    <label class="form__label" for="password-confirm">Confirm password</label>
                    <input class="form__input" id="password-confirm" type="password" name="password_confirmation" placeholder="* * * * * * * *" required>
                </div>
            </div>

            <div class="form__submit-wrap">
                <button class="form__submit btn" type="submit">Submit</button>
            </div>
        </form>
    </div>
</main>
</template>

<script>
export default {
    name: 'EditUser',
    data: () => ({
        user: [],
        inputSelect: [
        {
            title: 'Select role',
            value: '',
            selected: '' 
        },
        {
            title: 'User',
            value: 'user',
            selected: '' 
        },
        {
            title: 'Admin',
            value: 'admin',
            selected: '' 
        }
        ]
    }),
    mounted() {
        this.loadUser(this.$route.params.id);
    },
    methods: {
        loadUser(id) {
        axios.get('/api/getUser/' + id).then(res => {
            this.user = res.data;
            for (var i = 0; i < this.inputSelect.length; i++) {
                if (this.inputSelect[i].value === res.data.role) {
                    this.inputSelect[i].selected = 'selected';
                }
            }
        })
        }
    }
}
</script>
