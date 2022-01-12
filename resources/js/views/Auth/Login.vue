<template>
   <main class="site-main login-main">
      <div class="site-main-wrapper login-main-wrapper">
         <h1>Login page</h1>
         <form method="POST" :action="pageData.login_route">
            <input type="hidden" name="_token" :value="pageData.csrf_token">
            <input type="email" id="email" name="email" placeholder="Email" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
         </form>
      </div>
   </main>
</template>

<script>
   export default {
      name: 'Login',
      data: () => ({
         pageData: [],
      }),
      mounted() {
         this.loadPageData();
      },
      methods: {
         loadPageData() {
            axios.get('/api/getPageLogin').then(res => {
               this.pageData = res.data
            })
         }
      }
   }
</script>
