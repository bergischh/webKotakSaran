<template>
  <main>
    <div class="mt-16 px-10">
        <table class="w-full table-auto shadow-2xl">
            <thead class="border border-gray-300 border-b-2 rounded-xl">  
              <tr>
                  <th class="w-20">No</th>
                  <th class="p-5 w-72">Nama Kategori</th>
                  <th class="p-5 w-72">Nama Penempatan</th>
                  <th class="p-5 w-72">QR Code</th>
              </tr>
            </thead>
            <tbody>
                <tr v-for="(data, index) in this.qrcode" :key="index">
                  <td class="w-20 text-center border-b-2 rounded-xl">{{ index + 1 }}</td>
                  <td class="p-5 w-72 text-center border-b-2 rounded-xl">{{ data.nama_kategori }}</td>
                  <td class="p-5 w-72 text-center border-b-2 rounded-xl">{{ data.nama_penempatan }}</td>
                  <td class="p-5 w-72 content-center border-b-2 rounded-xl">
                    <img :src="`http://localhost:8000/qrcode_images/${data.qr_code_image}`" alt="qrcode" class="w-40 ml-20"/>
                    <!-- <img :src="`https://dev001.turjawali.com/KotakSaran/Be_Kotaksaran/public/qrcode_images/${data.qr_code_image}`"  alt="qrcode" class="w-40 ml-20"> -->
                  </td>
                </tr>
            </tbody>
        </table>
      </div>
  </main>
</template>

<script>
import $ from "jquery";
import {urlapi} from '@/lib/url.js';

export default {
  data() {
    return {
      qrcode: []
    }
  },
  methods: {
    getqrcode() {
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

      $.ajax({
        method: "GET",
        url: `${urlapi}/qrcode`,
        headers: config.headers,
        dataType: "JSON",
        success: function (response) {
          console.log(response);
          this.qrcode = response.data
        }.bind(this),
        error: function (error){
          console.log("error");
        }
      });
    },
  },
  created() {
    this.getqrcode();
  }
}
</script>