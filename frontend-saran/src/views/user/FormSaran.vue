<template>
  <main>
    <section class="body-font relative pr-6">
      <div class="container mx-auto ">
        <div class="title-form flex flex-col text-center mb-12 ">
          <h1 class="sm:text-3xl text-2xl font-medium  text-gray-900 mb-2">Kotak Saran Sekolah</h1>
          <p class="lg:w-2/3 mx-auto leading-relaxed text-base">untuk memberikan saran atau masukan, kepada sekolah untuk <br> 
            meningkatkan kualitas pendidikan, kebersihan dll.</p>
        </div>
            <idClock/>
      <form @submit.prevent="handleSubmit">
      <div class="lg:w-96 md:w-2/3 mx-auto">
              <div class="relative py-2">
                  <label for="name" class="leading-7 text-base">Nama</label>
                  <input type="text" id="nama" name="nama" v-model="nama" :readonly="anonymousChecked" class="drop-shadow-lg w-full bg-white bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
              </div>
              <div class="relative py-2">
                  <label for="email" class="leading-7 text-base">Email</label>
                  <input type="email" id="email" name="email" v-model="email" :readonly="anonymousChecked" class="drop-shadow-lg w-full bg-white bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
              </div>
              <div class="relative py-2">
                  <label for="no_telepon" class="leading-7 text-base">Nomor Telepon</label>
                  <input type="tel" id="no_telepon" name="no_telepon" v-model="no_telepon" :readonly="anonymousChecked" class="drop-shadow-lg w-full bg-white bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
              </div>
              <div class="relative py-2">
                  <label for="kategori" class="leading-7 text-base">Kategori</label>
                  <input type="text" id="nama_kategori" name="nama_kategori" v-model="nama_kategori" readonly
                  class="drop-shadow-lg w-full bg-white bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                  <input type="hidden" id="kategori_id" name="kategori_id" :value="kategori_id">

              </div>
              <div class="relative py-2">
                  <label for="penempatan" class="leading-7 text-base">Penempatan</label>
                  <input type="text" id="nama_penempatan" name="nama_penempatan" v-model="nama_penempatan" readonly
                  class="drop-shadow-lg w-full bg-white bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                  <input type="hidden" id="penempatan_id" name="penempatan_id"  :value="penempatan_id">

              </div>
              <div class="relative py-2">
                  <label for="saran" class="leading-7 text-base">Saran</label>
                  <textarea  id="saran" name="saran" v-model="saran" class="drop-shadow-lg w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
              </div>
              <div class="relative card-img">
                  <label for="foto" class="leading-7 text-base">Upload Gambar</label>
                  <input type="file" id="foto" ref="file" @change="handleFileUpload()" multiple class="bg-opacity	drop-shadow-lg w-full border-dashed border-2 px-2 border-indigo-500 mx-auto py-4  focus:outline-none rounded text-lg">
                   <div class="image p-3 flex flex-wrap" v-for="(preview, index) in fotoPreviews" :key="index">
                        <!-- <span class="delete" @click="deleteImage(index)"><b>&times;</b></span>-->
                        <img :src="preview" />
                   </div>
                  </div>
                  <span class="text-sm ml-2 text-red-600	">*Maksimal gambar 3</span>
              <div class="relative flex py-5">
                  <input type="checkbox" name="box" id="box" v-model="anonymousChecked" @change="handleAnonymous">
                  <label for="anonymous" class="text-xs ml-2">Klik disini jika anda ingin mengirim kotak saran sebagai anonymous</label>
              </div>
              <div class="p-2 w-full">
              <button type="submit" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">Kirim</button>
              </div>
          </div>
      </form>
    </div>
  </section>
  </main>
</template> 
    
<script>
import axios from 'axios';
import Swal from 'sweetalert2';
import idClock from '@/components/idClock.vue';

import { url } from '@/lib/url';
export default {
  components: {
    idClock,
  },
  data() {
    return {
      nama: '',
      email: '',
      no_telepon: '',
      saran: '',
      kategori_id: null,
      penempatan_id: null,
      nama_kategori: '',
      nama_penempatan: '',
      anonymousChecked: false,
      fotoPreviews: [],
      formData: new FormData(),
    };
  },
  methods: {
    handleAnonymous() {
      if (this.anonymousChecked) {
        this.nama = 'Anonymous';
        this.email = 'anonymous@gmail.co';
        this.no_telepon = '1234567890';
      }else {
        this.nama = '';
        this.email = '';
        this.no_telepon = '';
      } 
    },
    handleSubmit() {
      if (!this.anonymousChecked) {
        if (!this.nama || !this.email || !this.no_telepon || !this.saran || !this.nama_penempatan || !this.nama_kategori) {
          Swal.fire({
          icon: "error",
          title: "Gagal mengirim saran",
          text: "Harap lengkapi semua field",
          });
          return
        }
      }

      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailPattern.test(this.email)) {
        Swal.fire({
          icon: "error",
          title: "Gagal mengirim saran",
          text: "Format email tidak valid",
          });
          return
      }

      const phoneNumberPattern = /^[0-9]+$/;
      if (!phoneNumberPattern.test(this.no_telepon)) {
        Swal.fire({
          icon: "error",
          title: "Gagal mengirim saran",
          text: "Nomer telepon harus berisi angka",
          });
          return
      }

      let formData = new FormData();

      for (let i = 0; i < this.$refs.file.files.length; i++) {
        formData.append('foto[]', this.$refs.file.files[i]);
      }
      
      formData.append('nama', this.nama);
      formData.append('email', this.email);
      formData.append('no_telepon', this.no_telepon);
      formData.append('kategori_id', this.kategori_id);
      formData.append('penempatan_id', this.penempatan_id);
      formData.append('saran', this.saran);


      axios.post(`${url}/tambah-data/kotaksaran`, formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      }).then(res => {
        console.log(res.data)
        Swal.fire({
          position: "top",
          icon: "success",
          title: "Berhasil mengirim saran",
          text: "Terimakasih atas saranmu",
          showConfirmButton: false,
          timer: 1500
        });
        this.$router.push('/close');
      }).catch(error => {

        Swal.fire({
          position: "top",
          icon: "error",
          title: "Gagal mengirim saran",
          text: "Isi dengan data yang valid",
          showConfirmButton: false,
          timer: 1500
        });
      });
    },
    handleFileUpload() {
      this.clearFotoPrevies()
      const files = this.$refs.file.files;
      
      // Batasi jumlah file yang diunggah
      if (files.length + this.fotoPreviews.length > 3) {
        Swal.fire({
            position: "top",
            icon: "error",
            title: "Maksimal 3 foto",
            showConfirmButton: false,
            timer: 1500
        });
        this.$refs.file.value = ''; // Reset input file
        return;
      }
      
      // Proses setiap file yang diunggah
      for (let i = 0; i < files.length; i++) {
        const file = files[i];
        
        // Batasi jumlah file yang diunggah
        if (this.fotoPreviews.length >= 3) {
          Swal.fire({
            position: "top",
            icon: "error",
            title: "Maksimal 3 foto",
            showConfirmButton: false,
            timer: 1500
          });
          this.$refs.file.value = ''; // Reset input file
          return;
        }
        
        // Baca file sebagai URL data
        const reader = new FileReader();
        reader.onload = (e) => {
          // Menambahkan pratinjau gambar ke dalam array fotoPreviews
          this.fotoPreviews.push(e.target.result);
        };
        reader.readAsDataURL(file);
      }
    },
    clearFotoPrevies() {
      this.fotoPreviews = [];
    },
    deleteImage(index) {
        this.fotoPreviews.splice(index, 1);
    },
  },
  created() {
    // Mengambil nilai yang diteruskan dari QRreader.vue
    this.kategori_id = this.$route.query.kategori_id;
    this.penempatan_id = this.$route.query.penempatan_id;
    this.nama_kategori = this.$route.query.nama_kategori;
    this.nama_penempatan = this.$route.query.nama_penempatan;
  }
};
</script>


<style lang="scss" scoped>
.title-form {
  h1 {
      font-family: "Roboto", sans-serif;
      font-weight: 700;
  }
  p {
      font-family: "Roboto", sans-serif;
      font-weight: 300;
  }
}

label {
  color: black;
  font-family: "Roboto", sans-serif;
  font-weight: 400;
}

.card-img {
  width: 100%;
  height: auto;
  display: flex;
  justify-content: flex-start;
  align-items: flex-start;
  flex-wrap: wrap;
  min-height: 200px;
  position: relative;
  padding-top: 15px;
}

.relative .image{
  width: auto;
  margin-right: 5px;
  height: 75px;
  position: relative;

}
.relative .image img {
  width: 100%;
  height: 100%;
  border-radius: 5px;
}

.relative .image span {
  position: absolute;
  top: -2px;
  right: 9px;
  font-size: 23px;
  cursor: pointer;
}

</style>