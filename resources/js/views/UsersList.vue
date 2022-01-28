<template>
   <main class="users-list-main">
      <div class="users-list-main__wrapper wrapper">
         <h1 class="users-list-main__title title">Users list</h1>
         <div>
            <table class="table">
               <thead>
                  <tr>
                     <th>First name</th>
                     <th>Last name</th>
                     <th>Photo</th>
                     <th>User post</th>
                     <th>Email</th>
                     <th>Role</th>
                     <th>Edit link</th>
                     <th>Delete link</th>
                  </tr>
               </thead>
               <tbody>
                  <tr v-for="(user, index) in usersList" :key="index">
                     <td>{{ user.first_name }}</td>
                     <td>{{ user.last_name }}</td>
                     <td><img :src='user.photo' alt="photo"></td>
                     <td>{{ user.user_post }}</td>
                     <td>{{ user.email }}</td>
                     <td>{{ user.role }}</td>
                     <td>
                        <router-link :to="'/edit-user/'+user.id">Edit user</router-link>
                     </td>
                     <td>
                        <router-link :to="'/delete-user/'+user.id">Delete user</router-link>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
   </main>
</template>
<script>
   export default {
      name: 'UsersList',
      data: () => ({
         usersList: [],
      }),
      mounted() {
         this.loadPageData();
      },
      methods: {
         loadPageData() {
            axios.get('/api/getAllUsers').then(res => {
               this.usersList = res.data
            })
         }
      }
   }
</script>
