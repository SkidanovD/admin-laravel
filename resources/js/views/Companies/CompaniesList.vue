<template>
   <main class="companies-list-main">
      <div class="companies-list-main__wrapper wrapper">
         <h1 class="companies-list-main__title title">Companies list</h1>
         <div class="button-wrapper">
            <router-link to="/add-company" class="btn">Add company</router-link>
         </div>
         <div>
            <table class="table">
               <thead>
                  <tr>
                     <th>Name</th>
                     <th>Company name</th>
                     <th>Address</th>
                     <th>Post code</th>
                     <th>City</th>
                     <th>Phone</th>
                     <th>Siret</th>
                     <th>RCS</th>
                     <th>TVA</th>
                     <th>Note</th>
                     <th>Edit link</th>
                     <th>Delete link</th>
                  </tr>
               </thead>
               <tbody>
                  <tr v-for="(company, index) in companiesList" :key="index">
                     <td>{{ company.name }}</td>
                     <td>{{ company.company_name }}</td>
                     <td>{{ company.address }}</td>
                     <td>{{ company.post_code }}</td>
                     <td>{{ company.city }}</td>
                     <td>{{ company.phone }}</td>
                     <td>{{ company.siret }}</td>
                     <td>{{ company.rcs }}</td>
                     <td>{{ company.tva }}</td>
                     <td>{{ company.note }}</td>
                     <td>
                        <router-link :to="'/edit-company/'+company.id">Edit company</router-link>
                     </td>
                     <td>
                        <a href="#" @click.prevent="deleteCompany" :data-id="company.id">Delete company</a>
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
      name: 'CompaniesList',
      data: () => ({
         companiesList: [],
      }),
      mounted() {
         this.loadPageData();
      },
      methods: {
         loadPageData() {
            axios.get('/api/getAllCompanies').then(res => {
               if (res.data.status === 'success') {
                  this.companiesList = res.data.all_companies
               }
               
            })
         },
         deleteCompany(e) {
            axios({
               method: 'post',
               url: '/api/actionDeleteCompany',
               data: {
                  id: e.target.dataset.id,
               },
            }).then(
               res => {
                  this.loadPageData();
               }
            )
         }
      }
   }
</script>
