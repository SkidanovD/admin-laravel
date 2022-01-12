<template>
   <main class="site-main register-main">
      <div class="site-main-wrapper register-main-wrapper">
         <h1>Register page</h1>
         <form method="POST" :action="pageData.register_route">
            <input type="hidden" name="_token" :value="pageData.csrf_token">
            <p>
               <input type="text" id="first_name" name="first_name" placeholder="First name">
            </p>
            <p>
               <input type="text" id="last_name" name="last_name" placeholder="Last name">
            </p>
            <p>
               <input id="photo" type="file" name="photo">
            </p>
            <p>
               <input type="text" id="user_post" name="user_post" placeholder="User post">
            </p>
            <p>
               <input type="email" id="email" name="email" placeholder="Email" required>
            </p>
            <p>
               <select id="role" name="role" required>
                  <option value="admin">Admin</option>
                  <option value="user" selected>User</option>
               </select>
            </p>
            <p>
               <input type="password" id="password" name="password" placeholder="Password" required>
            </p>
            <p>
               <input id="password-confirm" type="password" name="password_confirmation" required>
            </p>
            <p>
               <button type="submit">Register</button>
            </p>
         </form>
      </div>
   </main>
</template>

<script>
   export default {
      name: 'Register',
      data: () => ({
         pageData: [],
      }),
      mounted() {
         this.loadPageData();
      },
      methods: {
         loadPageData() {
            axios.get('/api/getPageRegister').then(res => {
               this.pageData = res.data
            })
         }
      }
   }
</script>
