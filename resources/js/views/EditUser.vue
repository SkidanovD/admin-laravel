<template>
   <main class="site-main users-list-main">
      <div class="site-main-wrapper users-list-main-wrapper">
         <h1>Edit user</h1>
         <form action="" method="POST">
            <input id="id" type="hidden" name="id" :value="user.id">
            <p>
               <input type="text" id="first_name" name="first_name" placeholder="First name" :value="user.first_name">
            </p>
            <p>
               <input type="text" id="last_name" name="last_name" placeholder="Last name" :value="user.last_name">
            </p>
            <p>
               <input id="photo" type="file" name="photo" :value="user.photo">
            </p>
            <p>
               <input type="text" id="user_post" name="user_post" placeholder="User post" :value="user.user_post">
            </p>
            <p>
               <input type="email" id="email" name="email" placeholder="Email" :value="user.email" required>
            </p>
            <p>
               <select id="role" name="role" required>
                  <option v-for="(option, idx) in inputSelect" :key="idx" :value="option.value" :selected="option.selected">{{option.title}}</option>
               </select>
            </p>
            <p>
               <input type="password" id="password" name="password" placeholder="Password" required>
            </p>
            <p>
               <input id="password-confirm" type="password" name="password_confirmation" required>
            </p>
            <button type="submit">Submit</button>
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
