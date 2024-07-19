<template>
  <Sidebar/>
  <main>
    <Header/>    
     
    <div class="items-center content-center ml-5 mb-3 mt-10 grid grid-cols-6">
      <div class="col-start-1">
        <label class="text-base font-semibold">Pilih Penempatan :</label><br>
        <select v-model="selectedPenempatan" class="drop-shadow-lg px-3 py-2 mr-3 text-black rounded-md border border-gray-300 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
          <option selected disabled>Pilih Penempatan</option>
          <option v-for="(option, index) in penempatanOptions" :key="index" :value="option">{{ option }}</option>
        </select>
      </div>
      <div class="col-start-2 col-span-4">
        <label class="text-base font-semibold">Cari bedasarkan rentang tanggal :</label><br>    
        <input type="date" v-model="startDate" class="drop-shadow-lg px-3 py-2 mr-3 rounded-md border border-gray-300 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
        <span class="mr-3 text-base font-semibold">to</span>
        <input type="date" v-model="endDate" class="drop-shadow-lg px-3 py-2 mr-3 rounded-md border border-gray-300 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
        
        <button type="submit" @click="searchFitur" class="px-4 py-2 bg-indigo-400 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">Search</button>
        <button type="submit" @click="clearSearch" class="clear outline outline-indigo-400 px-4 py-1.5 ml-2 border border-indigo-400 text-indigo-400 rounded-md hover:text-white hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">Clear</button>
      </div>
      <div class="ml-10 flex items-center">
        <select v-model="entriesPerPage" @change="changeEntriesPerPage" class="mr-3 outline outline-indigo-500 rounded">
            <option v-for="option in entriesPerPageOptions" :key="option" :value="option">{{ option }}</option>
        </select>
        <button @click="scrollToBottom" class="top-13 right-9 bg-indigo-200 hover:bg-indigo-300 py-2 px-4 rounded">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
            <path stroke-linecap="round" stroke-linejoin="round" d="m9 12.75 3 3m0 0 3-3m-3 3v-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
          </svg>
        </button>
      </div>
    </div>

    <Chart></Chart>

    <div class="overflow-auto rounded-lg shadow ml-5 mt-5 mb-10">
        <table class="table-data w-full text-wrap whitespace-nowrap">
            <thead class="border border-b-2 border-gray-200">
                <tr class="text-sm font-semibold tracking-wide text-center">
                    <th class="p-3 w-1/8 md:w-auto">No</th>
                    <th class="p-3 w-1/6 md:w-auto">Waktu</th>
                    <th class="p-3 w-1/8 md:w-auto">Nama</th>
                    <th class="p-3 w-1/6 md:w-auto">Nama Kategori</th>
                    <th class="p-3 w-1/4 md:w-auto">Nama Penempatan</th>
                    <th class="p-3 w-1/6 md:w-auto">Saran</th>
                    <th class="p-3 w-1/8 md:w-auto">Foto</th>
                    <th class="p-3 w-1/4 md:w-auto">Email</th>
                    <th class="p-3 w-1/5 md:w-auto">No Telephone</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                <tr v-for="(data, index) in this.data" :key="index" class="text-sm text-gray-700">
                    <td class="p-3">{{ index + 1}}</td>
                    <td class="p-3">{{ getFormatDate(data.created_at) }}</td>
                    <td class="p-3">{{ data.nama }}</td>
                    <td class="p-3">{{ data.nama_kategori }}</td>
                    <td class="p-3">{{ data.nama_penempatan }}</td>
                    <td class="p-3">{{ data.saran }}</td>
                    <td class="p-3 img flex flex-wrap items-center">
                      <span v-for="(foto, index) in data.foto.split(',')" :key="index" class="p-2" :style="{ width: data.foto.split(',').length > 1 ? 'calc(41% - 10px)' : '45%', margin: data.foto.split(',').length === 1 ? '0 auto' : '0'}">
                        <img :src="`http://localhost:8000/kotaksaran_images/${foto}`" alt="foto_user" class="mr-1" :class="{'w-35' : data.foto.split(',').length === 1, 'w-35' : data.foto.split(',').length > 1}">
                        <!-- <img :src="`https://dev001.turjawali.com/KotakSaran/Be_Kotaksaran/public/kotaksaran_images/${foto}`" alt="foto_user" class="mr-2" :class="{'w-40' : data.foto.split(',').length === 1, 'w-40' : data.foto.split(',').length > 1}"> -->
                      </span>
                    </td>
                    <td class="p-3">
                      <a :href="'mailto:'+ data.email">{{ data.email }}</a> 
                    </td>
                    <td class="p-3">
                      <a v-if="data.no_telepon.length >= 12" :href="`https://wa.me/${data.no_telepon}`" class="text-sky-500" target="_blank">
                        {{ data.no_telepon }}
                      </a>
                      <span v-else>{{ data.no_telepon }}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="grid grid-cols-6 gap-4 ml-5 content-center mb-6">
        <div class="col-start-1 col-end-3 flex justify-center items-center mt-4">
          <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1 || isFiltered" class="px-3 py-1 mr-2 bg-indigo-400 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 disabled:bg-gray-400 disabled:cursor-not-allowed">Previous</button>
          <span class="mx-4">{{ currentPage }} of {{ totalPages }}</span>
          <button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages || isFiltered" class="px-3 py-1 ml-2 bg-indigo-400 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 disabled:bg-gray-400 disabled:cursor-not-allowed">Next</button>
        </div>

        <div class="col-end-9 col-span-2 mr-10">
            <button @click="scrollToTop" class="bottom-3 right-9 bg-indigo-200 hover:bg-indigo-300 py-2 px-4 rounded">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="m15 11.25-3-3m0 0-3 3m3-3v7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
              </svg>
            </button>
        </div>
    </div>
  </main>

</template>

<script>
import Header from '@/components/Header.vue';
import Sidebar from '../../components/Sidebar.vue';
import Chart from '@/components/chart.vue'

import axios from 'axios';
import Swal from 'sweetalert2';
import {urlapi} from '@/lib/url.js'

export default {
    name: 'Dashboard',
    data() {
        return {
            data: [],
            displayedData: [],
            startDate: '',
            endDate: '',
            penempatanOptions: [],
            selectedPenempatan: null,
            currentPage: 1,
            totalPages: null,
            entriesPerPage: 10,
            entriesPerPageOptions: [10, 20, 50, 100],
            isFiltered: false,
        }
    },
    mounted() {
        this.getKotakSaran();
    },
    methods: {
        getKotakSaran() {
            const jwtToken = localStorage.getItem('token')
            const config = {
                headers: {
                    Authorization: `Bearer ${jwtToken}`
                }
            }

            axios.get(`${urlapi}/data/saranall`, config)
                .then(res => {
                    if (res.data.success) {
                      this.allData = res.data.data;
                      this.filteredData = this.allData; 
                      this.penempatanOptions = [...new Set(this.allData.map(item => item.nama_penempatan))];
                      this.totalPages = Math.ceil(this.filteredData.length / this.entriesPerPage);
                      this.paginateData(); 
                    }
                })
                .catch(error => {
                    console.error('Error fetching data', error);
                });
        },
        paginateData() {
          if (this.isFiltered) {
            this.currentPage = 1;
            this.totalPages = 1;
          }
          const startIndex = (this.currentPage - 1) * this.entriesPerPage;
          const endIndex = startIndex + this.entriesPerPage;
          this.data = this.filteredData.slice(startIndex, endIndex);
        },
        changeEntriesPerPage() {
          this.currentPage = 1;
          this.totalPages = Math.ceil(this.filteredData.length / this.entriesPerPage);
          this.paginateData(); 
        },
        changePage(page) {
          this.currentPage = page;
          this.paginateData(); 
        },
        getFormatDate(dateString) {
          const options = { year: 'numeric', month: 'long', day: 'numeric'};
          return new Date(dateString).toLocaleDateString('id-ID', options);
        },
        searchFitur() {
          if (!this.startDate && !this.endDate && !this.selectedPenempatan) {
            Swal.fire({
              position: "top",
              icon: "info",
              title: "penempatan atau tanggal belum di pilih",
              showConfirmButton: false,
              timer: 1500
            });
            return;
          }

          const jwtToken = localStorage.getItem('token')
            const config = {
                headers: {
                    Authorization: `Bearer ${jwtToken}`
                }
            }
            axios.get(`${urlapi}/data/saranall`, config)
          .then(res => {
            if (res.data.success) {
              let filteredData = res.data.data;

              // Lakukan filter berdasarkan tanggal
              if (this.startDate && this.endDate) {
                const startDate = new Date(this.startDate);
                const endDate = new Date(this.endDate);

                endDate.setHours(23, 59, 59);

                // Filter data sesuai dengan rentang tanggal
                filteredData = filteredData.filter(item => {
                  const itemDate = new Date(item.created_at);
                  return itemDate >= startDate && itemDate <= endDate;
                });
              }

              // Lakukan filter berdasarkan penempatan
              if (this.selectedPenempatan) {
                filteredData = filteredData.filter(item => item.nama_penempatan === this.selectedPenempatan);
              }

              // Tampilkan data yang sesuai dengan filter
              this.data = filteredData;

              this.isFiltered = this.startDate || this.endDate || this.selectedPenempatan;
              this.currentPage = 1;
              this.totalPages = 1;
            }
          })
          .catch(error => {
            console.error('Error fetching data', error);
          });
        },
        scrollToTop() {
          window.scrollTo({
            top: 0,
            behavior: 'smooth' 
          });
        },
        scrollToBottom() {
          window.scrollTo({
            top: document.body.scrollHeight, 
            behavior: 'smooth' 
          });
        },
        clearSearch() {
          this.startDate = '';
          this.endDate = '';
          this.selectedPenempatan = null;
          this.isFiltered = false;

          this.getKotakSaran();
        }
    },
    mounted() {
      this.getKotakSaran()
    },
    components: {
      Header,
      Sidebar,
      Chart
    }
}
</script>

<style lang="scss" scoped>
tbody tr:nth-child(odd) {
  background-color: #ffffff;
}
tbody tr:nth-child(even) {
  background-color: #eeee;
}
th {
  font-family: "Roboto", sans-serif;
  font-weight: 500;
  color: black;
}
td {
  font-family: "Roboto", sans-serif;
  font-weight: 400;
}

@media (max-width: 640px) {
  table {
    overflow-x: auto;
    display: block;
  }

  th, td {
    min-width: 100px;
    max-width: 200px;
    overflow-wrap: break-word;
  }

  thead {
    display: block;
    position: sticky;
    top: 0;
    z-index: 1;
    background-color: white; /* Optional: Add background color */
  }

  tbody {
    display: block;
    margin-top: 2rem; /* Optional: Adjust margin for better spacing */
  }

  tr {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    margin-bottom: 1rem; /* Optional: Adjust margin for better spacing */
  }

  td {
    width: calc(50% - 1rem); /* Optional: Adjust column width */
    margin-bottom: 1rem; /* Optional: Adjust margin for better spacing */
  }

  th {
    width: 100%; /* Optional: Adjust column width */
  }
  
  th:nth-child(5), td:nth-child(5) {
        width: 80px; /* Atur lebar kolom Saran pada layar yang lebih kecil */
        max-width: 80px; /* Jika diperlukan, atur maksimum lebar kolom */
        overflow: hidden; /* Atur overflow untuk menghindari konten yang terpotong */
        white-space: nowrap; /* Hindari wrap konten pada kolom Saran */
    }
}
</style>

