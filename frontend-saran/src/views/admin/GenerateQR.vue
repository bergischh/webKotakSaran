<template>
  <Sidebar />
  <main>
    <Header />
    <Tab></Tab>
    <section class="text-gray-600 body-font">
      <div class="container mx-full flex flex-wrap items-center">
        <div class="lg:w-2/6 md:w-1/2 bg-gray-100 rounded-lg p-5 flex flex-col md:ml-auto w-full mt-10 md:mt-0">
          <h2 class="text-gray-900 text-lg font-medium title-font mb-5">Generate QR</h2>
          <form @submit.prevent="generateQR" class="shadow-xl">
            <div class="relative mb-4">
              <label for="kategori" class="leading-7 text-sm text-gray-600">Pilih Kategori</label>
                <select name="kategori" id="kategori" v-model="kategoriValue" class="option w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-2 px-3 leading-8 duration-200 ease-in-out">
                  <option selected disabled hidden>Silahkan Pilih kategori</option>
                  <option v-for="item in kategori" :key="item.id" :value="item.id">{{ item.nama_kategori }}</option>
                </select>
            </div>
            <div class="relative mb-4">
              <label for="penempatan" class="leading-7 text-sm text-gray-600">Pilih Penempatan</label>
              <select id="penempatan" v-model="penempatanValue" class="option w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-2 px-3 leading-8 duration-200 ease-in-out">
                <option selected disable hidden>Silahkan pilih tempat</option>
                <option v-for="item in penempatan" :key="item.id" :value="item.id">{{ item.nama_penempatan }}</option>
                <option>Kamar Mandi</option>					
              </select>
            </div>
            <div class="button-login mt-5 rounded-lg bg-indigo-400">
              <button type="submit" class="w-full text-white py-1">Generate QR Code</button>
            </div>
          </form>
        </div>
        <!-- GENERATE QR CODE -->
        <div class="generate-qr lg:w-3/5 md:w-20 md:pr-16 lg:pr-0 pr-0 ml-15 px-5 pt-20">
          <div class="flex justify-center items-center h-64">
            <div v-if="showQRCode" class="show-qr rounded-lg">
              <span class="text-gray-900 text-lg font-medium title-font">QR Code:</span>
              <qrcode-vue ref="qrcode" id="qr-code" :value="QRValue" :size="200" level="H" />
              <button @click="downloadQrCode" type="submit" class="bg-indigo-400 mt-5 py-1 w-full rounded-lg text-white">Download</button>
              <div class="mt-3 text-gray-900 font-medium">
                <h4>Kategori : {{ kategoriNama }}</h4>
                <h3>Penempatan : {{ penempatanNama }}</h3>
              </div>
            </div>
          </div>  
        </div>
        </div>
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
    </section>
  </main>

</template>

<script>
import Tab from '@/components/Form-qr.vue';
import Sidebar from '@/components/Sidebar.vue';
import Header from '@/components/Header.vue';
import QrcodeVue from 'qrcode.vue';
import $ from "jquery";
import {urlapi} from '@/lib/url.js'

export default {
  name: 'generate',
  data() {
    return {
      kategoriValue: null,
      penempatanValue: null,
      selectedKategori: null,
      selectedPenempatan: null,
      QRValue: null,
      showQRCode: false,
      kategori: [],
      penempatan: [],
      kategoriNama: null,
      penempatanNama: null,
      qrcode: [],
    }
  },
  methods: {
    async generateQR() {
    if (this.kategoriValue && this.penempatanValue) {
        const kategoriId = this.kategoriValue.split('-')[0];
        const kategoriNama = this.kategoriValue.split('-')[1];
        const penempatanId = this.penempatanValue.split('-')[0];
        const penempatanNama = this.penempatanValue.split('-')[1];

        this.penempatanNama = penempatanNama;
        this.kategoriNama = kategoriNama;

        this.QRValue = `${kategoriId}-${kategoriNama}-${penempatanId}-${penempatanNama}`;
        this.showQRCode = true;

        const jwtToken = localStorage.getItem('token')
          const config = {
            headers: {
              Authorization: `Bearer ${jwtToken}`
            }
          }

        $.ajax({
          method: 'POST',
          url: `${urlapi}/data/qrcode`,
          headers: config.headers,
          contentType: 'application/json',
          data: JSON.stringify({
            kategori_id: kategoriId,
            penempatan_id: penempatanId,
            qr_code_value: this.QRValue,
          }),
          success: function(response) {
            console.log('Data berhasil dikirim ke backend:', response);
            this.showQRCode = true;
            this.QRValue = response.data.qr_code_value;
          },
          error: function(error) {
            console.error('Terjadi kesalahan saat mengirim data ke backend:', error);
          },
        });
      }
      this.getqrcode();
    },
    async downloadQrCode() {
      const qrCodeElement =  this.$refs.qrcode.$el;

      const canvas = document.createElement('canvas');
      canvas.width = qrCodeElement.offsetWidth;
      canvas.height = qrCodeElement.offsetHeight;

      const context = canvas.getContext('2d');
      context.drawImage(qrCodeElement, 0, 0);
      const qrCodeUrl = canvas.toDataURL('image/png');

      const downloadLink = document.createElement('a')
      downloadLink.href = qrCodeUrl;
      downloadLink.download = 'QR-code.png';

      downloadLink.click();

    },
    getKategori() {
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
        url: `${urlapi}/kategoriall`,
        headers: config.headers,
        dataType: "json",
        success: function (response){
          console.log(response);
          $("#kategori").html("<option selected disabled>Silahkan Pilih Kategori</option>");
          for (let index = 0; index < response.data.length; index++) {
            const element = response.data[index];
            $("#kategori").append("<option value='"+element["id"]+"-"+element["nama_kategori"]+"'>"+element["nama_kategori"]+"</option>")
          }
        },
        error: function (error){
          console.log(error.response.data);
        }
      });
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
      $.ajax({
        method: "GET",
        url: `${urlapi}/penempatanall`,
        headers: config.headers,
        dataType: "json",
        success: function (response){
          console.log(response);
          $("#penempatan").html("<option selected disabled>Silahkan Pilih Penempatan</option>");
          for (let index = 0; index < response.data.length; index++) {
            const element = response.data[index];
            $("#penempatan").append("<option value='"+element["id"]+"-"+element["nama_penempatan"]+"'>"+element["nama_penempatan"]+"</option>")
          }
        },
        error: function (error){
          console.log("error");
        }
      });
    },
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
    this.getKategori();
    this.getPenempatan();
    this.generateQR();
    this.getqrcode();
  },
  components: {
    Tab,
    Sidebar,
    Header,
    QrcodeVue,
  }
}
</script>


<style scoped>
.option {
  transition: all 0.3s ease;
}

.button-login button {
  transition: 0.2s ease;
}

.button-login button:hover {
  background-color: rgb(55 48 163);
  border-radius: 0.5rem;
}

@media (max-width: 768px) {
  main {
    padding-left: 3.9rem;
  }
}
</style>
