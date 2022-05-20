<template>
   <main class="site-main users-list-main">
      <div class="site-main-wrapper users-list-main-wrapper width-container">
         <h1 class="page-title users-list-page-title">Users</h1>
         <div class="add-use-block">
            <div class="button-wrapper">
               <div class="button-hover">
                  <router-link to="/register" class="button">Add user</router-link>
               </div>
            </div>
         </div>
         <div class="user-list">
            <div class="user-item" v-for="(user, index) in usersList" :key="index">
               <div class="photo-column">
                  <div class="image-wrapper" v-if="user.photo">
                     <img class="photo" :src="user.photo" :alt="user.first_name + ' ' + user.last_name">
                  </div>
                  <div class="image-wrapper default" v-else>
                     <img class="photo" src="img/icons/icon-incognito.svg" :alt="user.first_name + ' ' + user.last_name">
                  </div>
               </div>
               <div class="text-column">
                  <h2 class="h4 name" v-if="user.first_name || user.last_name">{{ user.first_name }} {{ user.last_name }}</h2>
                  <a :href="'mailto:'" class="email">{{ user.email }}</a>
                  <div class="role">{{ user.role }}</div>
               </div>
               <div class="action-column">
                  <div class="btn-wrapper btn-edit-wrapper">
                     <router-link :to="'/edit-user/'+user.id" class="btn btn-edit">
                        <svg enable-background="new 0 0 32 32" height="32px" id="Layer_1" version="1.1" viewBox="0 0 32 32" width="32px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                           <path d="M29.395,2.58C27.75,0.937,25.584,0,23.449,0c-1.801,0-3.459,0.668-4.67,1.877l-4.867,4.904  c-0.015,0.014-0.032,0.023-0.047,0.038c-0.008,0.008-0.013,0.019-0.021,0.026l0.002,0.002L3.517,17.256  c-0.476,0.473-0.821,1.062-1.013,1.705l-2.349,8.508C0.153,27.492,0,28.16,0,28.5C0,30.432,1.569,32,3.504,32  c0.385,0,1.13-0.184,1.157-0.188l8.478-2.229c0.644-0.191,1.229-0.539,1.705-1.016l15.263-15.383  C32.883,10.406,32.57,5.75,29.395,2.58z M16.014,23.795c-0.082-0.902-0.337-1.787-0.719-2.627l9.455-9.454  c0.578,1.826,0.281,3.736-0.986,5.004c-0.008,0.008-0.018,0.013-0.025,0.021l0.014,0.013l-7.728,7.79  C16.025,24.293,16.037,24.049,16.014,23.795z M14.793,20.256c-0.373-0.613-0.797-1.205-1.322-1.729  c-0.611-0.611-1.312-1.09-2.044-1.492l9.532-9.532c0.748,0.332,1.465,0.805,2.098,1.438c0.541,0.539,0.959,1.143,1.281,1.771  L14.793,20.256z M10.486,16.562c-0.926-0.373-1.896-0.586-2.868-0.599l7.703-7.762c1.179-1.15,2.896-1.481,4.587-1.062  L10.486,16.562z M4.167,29.873C4.058,29.898,3.719,29.984,3.489,30C2.667,29.99,2,29.322,2,28.5  c0.012-0.168,0.079-0.457,0.102-0.562l1.053-3.814c1.143-0.031,2.373,0.414,3.34,1.383c0.982,0.98,1.444,2.234,1.394,3.391  L4.167,29.873z M8.874,28.637c-0.024-1.342-0.57-2.738-1.672-3.838C6.16,23.756,4.796,23.154,3.436,23.1l0.996-3.607  c0.072-0.24,0.215-0.477,0.391-0.684c2.006-1.436,5.091-1.012,7.234,1.133c2.267,2.266,2.617,5.586,0.871,7.568  c-0.116,0.061-0.233,0.119-0.359,0.156L8.874,28.637z M28.691,11.772l-1.684,1.697c0-0.226,0.027-0.443,0.006-0.674  c-0.176-1.935-1.078-3.806-2.543-5.269c-1.629-1.63-3.789-2.565-5.928-2.571l1.656-1.67C21.027,2.458,22.184,2,23.449,2  c1.609,0,3.262,0.728,4.533,1.995c1.193,1.191,1.904,2.671,2.006,4.168C30.082,9.56,29.621,10.841,28.691,11.772z" fill="#676767" id="pen"/>
                        </svg>
                     </router-link>
                  </div>
                  <div class="btn-wrapper btn-delete-wrapper">
                     <button type="button" @click="actionDeleteUser" class="btn btn-delete">
                        <svg height="32px" id="Layer_1" version="1.1" viewBox="0 0 32 32" width="32px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                           <g id="trash">
                              <path clip-rule="evenodd" d="M29.98,6.819c-0.096-1.57-1.387-2.816-2.98-2.816h-3v-1V3.001   c0-1.657-1.344-3-3-3H11c-1.657,0-3,1.343-3,3v0.001v1H5c-1.595,0-2.885,1.246-2.981,2.816H2v1.183v1c0,1.104,0.896,2,2,2l0,0v17   c0,2.209,1.791,4,4,4h16c2.209,0,4-1.791,4-4v-17l0,0c1.104,0,2-0.896,2-2v-1V6.819H29.98z M10,3.002c0-0.553,0.447-1,1-1h10   c0.553,0,1,0.447,1,1v1H10V3.002z M26,28.002c0,1.102-0.898,2-2,2H8c-1.103,0-2-0.898-2-2v-17h20V28.002z M28,8.001v1H4v-1V7.002   c0-0.553,0.447-1,1-1h22c0.553,0,1,0.447,1,1V8.001z" fill="#676767" fill-rule="evenodd"/>
                              <path clip-rule="evenodd" d="M9,28.006h2c0.553,0,1-0.447,1-1v-13c0-0.553-0.447-1-1-1H9   c-0.553,0-1,0.447-1,1v13C8,27.559,8.447,28.006,9,28.006z M9,14.005h2v13H9V14.005z" fill="#676767" fill-rule="evenodd"/>
                              <path clip-rule="evenodd" d="M15,28.006h2c0.553,0,1-0.447,1-1v-13c0-0.553-0.447-1-1-1h-2   c-0.553,0-1,0.447-1,1v13C14,27.559,14.447,28.006,15,28.006z M15,14.005h2v13h-2V14.005z" fill="#676767" fill-rule="evenodd"/>
                              <path clip-rule="evenodd" d="M21,28.006h2c0.553,0,1-0.447,1-1v-13c0-0.553-0.447-1-1-1h-2   c-0.553,0-1,0.447-1,1v13C20,27.559,20.447,28.006,21,28.006z M21,14.005h2v13h-2V14.005z" fill="#676767" fill-rule="evenodd"/>
                           </g>
                        </svg>
                     </button>
                  </div>
               </div>
            </div>
         </div>
         
         <!-- <div>
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
         </div> -->
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
               if (res.data.status === 'success') {
                  this.usersList = res.data.all_users
               }
               
            })
         }
      }
   }
</script>
