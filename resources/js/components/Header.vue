<template>
   <header class="site-header">
      <div class="site-header-wrapper">
      <div class="logo">
         <h1>Invoice generator</h1>
      </div>
      <nav>
         <ul>
            <li v-for="link in links">
               <router-link :to="link.href">{{link.title}}</router-link>
            </li>
            <li>
               <form method="POST" action="/api/actionLogout">
                  <input type="hidden" name="_token" :value="csrfToken">
                  <button type="submit">Logout</button>
               </form>
            </li>
         </ul>
      </nav>
      </div>
   </header>
</template>

<script>
   export default {
      data: () => ({
         links: [
            {
               title: 'Home',
               href: '/'  
            },
            {
               title: 'Register',
               href: '/register'
            },
            {
               title: 'Login',
               href: '/login'
            },
            {
               title: 'Users list',
               href: '/users-list'
            },
         ],
         csrfToken: [],
         authUser: [],
      }),
      mounted() {
         this.getCSRFToken();
         this.getAuthUser();
      },
      methods: {
         getCSRFToken() {
            axios.get('/api/getCSRFToken').then(res => {
               this.csrfToken = res.data
            })
         },
         getAuthUser() {
            axios.get('/api/getAuthUser').then(res => {
               this.authUser = res.data
            })
         },
      }
   }
</script>

