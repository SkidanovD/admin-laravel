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
         </ul>
      </nav>
      </div>
   </header>
</template>

<script>
   export default {
      data() {
         return {
            links: [
               {
                  title: 'Home',
                  href: '/'
               },
               {
                  title: 'User',
                  href: '/user'
               },
               {
                  title: 'User list',
                  href: '/user-list'
               },
            ]
         }
      },
   }
</script>

