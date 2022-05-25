<template>
   <main class="site-main companies-list-main">
      <div class="site-main-wrapper companies-list-main-wrapper width-container">
         <h1 class="page-title companies-list-page-title">Companies</h1>
         <div class="companies-page-content" v-if="getAllCompanies && companiesList.length">
            <div class="button-wrapper add-company-button-wrapper">
               <div class="button-hover">
                  <router-link to="/add-company" class="button add-company-butto">Add company</router-link>
               </div>
            </div>
            <div class="companies-list">
               <div class="companies-list-wrapper">
                  <router-link :to="/company/ + company.id" class="company-item" v-for="(company, index) in companiesList" :key="index">
                     <div class="company-item-wrapper">
                        <div class="image-wrapper">
                           <svg data-name="Layer 3" id="Layer_3" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                              <line class="cls-1" style="stroke-linecap:round;stroke-linejoin:round;stroke-width:2px;" fill="none" stroke="#676767" x1="6" x2="26" y1="26" y2="26"/>
                              <rect class="cls-1" style="stroke-linecap:round;stroke-linejoin:round;stroke-width:2px;" fill="none" stroke="#676767" height="16" width="10" x="14" y="10"/>
                              <rect class="cls-1" style="stroke-linecap:round;stroke-linejoin:round;stroke-width:2px;" fill="none" stroke="#676767" height="13" width="6" x="8" y="13"/>
                              <rect class="cls-2" fill="#676767" height="13" width="2" x="12" y="13"/>
                              <line class="cls-3" style="stroke-miterlimit:10;" fill="none" stroke="#676767" x1="11" x2="11" y1="13" y2="26"/>
                              <line class="cls-4" style="stroke-linecap:round;stroke-miterlimit:10;" fill="none" stroke="#676767" x1="15" x2="21" y1="13.5" y2="13.5"/>
                              <line class="cls-4" style="stroke-linecap:round;stroke-miterlimit:10;" fill="none" stroke="#676767" x1="15" x2="21" y1="16.5" y2="16.5"/>
                              <line class="cls-4" style="stroke-linecap:round;stroke-miterlimit:10;" fill="none" stroke="#676767" x1="15" x2="21" y1="19.5" y2="19.5"/>
                              <rect class="cls-1" style="stroke-linecap:round;stroke-linejoin:round;stroke-width:2px;" fill="none" stroke="#676767" height="3" width="6" x="16" y="7"/>
                              <line class="cls-1" style="stroke-linecap:round;stroke-linejoin:round;stroke-width:2px;" fill="none" stroke="#676767" x1="19" x2="19" y1="7" y2="5"/>
                           </svg>
                        </div>
                        <div class="text-wrapper">
                           <h2 class="company-item-title h4">{{ company.company_name }}</h2>
                        </div>
                     </div>
                  </router-link>
               </div>
            </div>
            <!-- <table class="table">
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
            </table> -->
         </div>



         
         <div class="no-companies" v-if="getAllCompanies && !companiesList.length">
               <div class="text message message-info">No company has been created yet. In order to create the first company, click the «Add invoice» button.</div>
               <div class="button-wrapper">
                  <div class="button-hover">
                     <router-link to="/add-company" class="button">Add company</router-link>
                  </div>
               </div>
         </div>
      </div>
   </main>
</template>
<script>
   export default {
      name: 'CompaniesList',
      data: () => ({
         companiesList: [],
         getAllCompanies: false
      }),
      mounted() {
         this.loadPageData();
      },
      methods: {
         loadPageData() {
            axios.get('/api/getAllCompanies').then(res => {
               this.getAllCompanies = true;
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
