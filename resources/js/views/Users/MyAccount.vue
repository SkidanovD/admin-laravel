<template>
    <main class="site-main account-main">
        <div class="site-main-wrapper account-main-wrapper width-container">
            <h1 class="page-title account-page-title">My account</h1>
            <div class="user-main-info">
                <div class="left-column">
                    <div class="user-photo">
                        <div class="image-wrapper" v-if="user.photo">
                            <img :src="user.photo" :alt="user.first_name + ' ' + user.last_name">
                        </div>
                        <div class="image-wrapper default" v-else>
                            <img src="/img/icons/icon-incognito.svg" :alt="user.first_name + ' ' + user.last_name">
                        </div>
                    </div>
                </div>
                <div class="right-column">
                    <div class="block-info-item user-info-item">
                        <div class="block-info-label user-info-label">Name</div>
                        <div class="block-info-value user-info-value user-info-name h3" v-if="user.first_name || user.last_name">{{ user.first_name }} {{ user.last_name }}</div>
                    </div>
                    <div class="block-info-item user-info-item">
                        <div class="block-info-label user-info-label">Post</div>
                        <div class="block-info-value user-info-value user-info-post h5" v-if="user.user_post">{{ user.user_post }}</div>
                    </div>
                    <div class="block-info-item user-info-item">
                        <div class="block-info-label user-info-label">Email</div>
                        <div class="block-info-value user-info-value user-info-email h4" v-if="user.email">{{ user.email }}</div>
                    </div>
                    <div class="block-info-item user-info-item">
                        <div class="block-info-label user-info-label">Role</div>
                        <div class="block-info-value user-info-value user-info-role h5" v-if="user.role">{{ user.role }}</div>
                    </div>
                </div>
            </div>
            <div class="account-button-block">
                <div class="button-wrapper">
                    <div class="button-hover">
                        <router-link :to="'/edit-user/'+user.id" class="button account-edit-button">Edit</router-link>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
    export default {
        name: 'MyAccount',
        data: () => ({
            user: [],
        }),
        mounted() {
            this.unAuthenticated();
            this.getUser(this.$route.params.id);
        },
        methods: {
            unAuthenticated() {
                axios.get('/api/unAuthenticated').catch(err => {
                    location = '/login';
                })
            },
            getUser(id) {
                axios.get('/api/getUser/' + id).then(res => {
                    if (res.data.status === 'success') {
                        this.user = res.data.user;
                    }
                })
            },
        }
    }
</script>
