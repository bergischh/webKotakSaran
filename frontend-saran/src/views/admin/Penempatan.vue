<template>
    <Sidebar />
    <main>
        <Header />
        <Tab></Tab>
         <div class="grid grid-cols-3 ml-10 mt-10">
            <div class="container">
             <div class="max-w-lg mx-auto shadow-md hover:shadow-lg rounded-lg overflow-hidden">
                 <div class="py-8 px-6 md:px-10 lg:px-12">
                     <h2 class="text-2xl lg:text-3xl font-semibold mb-4 text-center">Tambah Penempatan</h2>
                     <form @submit.prevent="savePenempatan" class="space-y-4" method="post">
                         <div>
                             <input id="penempatan" v-model="model.penempatan.nama_penempatan" type="text" placeholder="Masukkan Nama Tempat" class="w-full bg-white rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-2 px-4 duration-200 ease-in-out">
                         </div>
                         <div>
                             <button type="submit" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white py-2 px-4 rounded-lg transition duration-300">Submit</button>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
            <div class="col-span-2 mx-auto w-3/4 shadow-xl rounded-xl max-h-80 overflow-y-auto">
                <table class="w-full table-auto">
                    <thead class="border border-gray-200 border-b-2">  
                        <tr>
                            <th class="p-5 w-60">No</th>
                            <th class="p-5 w-72">Nama Penempatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(data, index) in this.data" :key="index" >
                            <td class="p-5 w-60 text-center">{{ index + 1 }}</td>
                            <td class="p-5 w-72 text-center">{{ data.nama_penempatan}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
 </template>
 
<script>
import Tab from '@/components/Form-qr.vue'
import Sidebar from '@/components/Sidebar.vue'
import Header from '@/components/Header.vue'
import axios from 'axios'
import Swal from 'sweetalert2'

import {urlapi} from '@/lib/url.js'

    export default {
        name: 'Penempatan',
        data() {
            return {
                data: [],
                errorList: '',
                errorMessage: '',
                model: {
                    penempatan: {
                        nama_penempatan: '',
                    }
                }
            }
        },
        methods: {
            savePenempatan() {
                const jwtToken = localStorage.getItem('token')
                if (!jwtToken) {
                    this.errorMessage = 'Anda harus login';
                    return
                }

                if (!this.model.penempatan.nama_penempatan) {
                    Swal.fire({
                    icon: "error",
                    title: "Gagal menambah data",
                    text: "Harap isi field form penempatan"
                    });
                    return
                }

                const config = {
                    headers: {
                    Authorization: `Bearer ${jwtToken}`
                    }
                }
          
                var mythis = this;
                axios.post(`${urlapi}/tambah-data/penempatan`, this.model.penempatan, config).then(res => {
                    console.log(res.data)
                
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil menambah data penempatan",
                    });

                    this.getPenempatan();
        
                    this.model.penempatan = {
                        nama_penempatan: '', 
                    }
                })
                .catch(function (error) {
                    let errorMessage = 'Data yang anda inputkan sudah ada'
                    console.log('Error', error.message);
                    Swal.fire({
                        icon: "error",
                        title: "Terjadi kesalahan",
                        text: errorMessage,
                    });
                })
            },
            getPenempatan() {
                const jwtToken = localStorage.getItem('token')
                if (!jwtToken) {
                    this.errorMessage = 'Anda harus login';
                    return
                }

                const config = {
                    headers: {
                    Authorization: `Bearer ${jwtToken}`
                    }
                }

                axios.get(`${urlapi}/penempatanall`, config)
                .then(res => {
                    this.data = res.data.data;
                })
                .catch(error => {
                    console.error('Error fetching data', error);
                });
            }
        },
        mounted() {
            this.getPenempatan()
        },
        components: {
            Tab,
            Sidebar,
            Header,
        }
    }
</script>

<style scoped>
 input {
     background-color: #E2E6EE;
 }
 h2 {
     font-family: "Roboto", sans-serif;
     font-weight: 400;
 }
 button {
     cursor: pointer;
 }
 tbody tr:nth-child(even) {
    background-color: #eeeeee;
 }
 tbody tr:nth-child(odd) {
    background-color: #ffffff;
 }

 @media (max-width: 768px) {
  main {
    padding-left: 3.9rem;
  }
 }
</style>
 