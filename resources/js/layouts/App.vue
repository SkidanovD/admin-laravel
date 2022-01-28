<template>
   <div class="main">
      <vueHeader></vueHeader>
      <router-view></router-view>
      <vueFooter></vueFooter>
   </div>
</template>

<script>
   import vueHeader from './../components/Header';
   import vueFooter from './../components/Footer';

   export default {
      components: {
         vueHeader,
         vueFooter,
      },
   }
</script>

