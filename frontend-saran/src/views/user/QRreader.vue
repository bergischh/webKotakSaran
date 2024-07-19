<template>
  <main>
      <h2 class="text-2xl lg:text-3xl font-semibold mb-4 text-center">Scan QR Code here</h2>
      <div id="qr-code-full-region" class="bg-white shadow-2xl"></div>
          <div v-for="(msg, index) in message" :key="index" style="white-space: pre-line" class="decoded-message">
              <pre>decodedResult => {{ msg.decodedResult }}</pre>
          </div>
  </main>
</template>

<script>
import { Html5QrcodeScanner } from "html5-qrcode";

export default {
  name: 'QRreader',
  data() {
    return {
      message: [],
    };
  },
  methods: {
    onScanSuccess(decodedText, decodedResult) {
      const obj = { decodedResult: decodedResult };
      this.message.push(obj);
      const [kategoriId, kategoriNama, penempatanId, penempatanNama] = decodedText.split('-')

      // axios.get(`${url}/qrcode?kategoriId=${kategoriId}&kategoriNama=${kategoriNama}&penempatanId=${penempatanId}&penempatanNama=${penempatanNama}`)
      // .then(response => {
      //   if (response.data.exist) {

          this.$router.push({
          name: "FormSaran", 
          query: {
          kategori_id: kategoriId, 
          nama_kategori: kategoriNama,
          penempatan_id: penempatanId,
          nama_penempatan: penempatanNama
            }
          });    
    },
    createScan() {
      const config = { fps: 20, qrbox: { width: 250, height: 250 } };
      const html5QrcodeScanner = new Html5QrcodeScanner("qr-code-full-region", config);
      html5QrcodeScanner.render(this.onScanSuccess);
    },
  },
  mounted() {
    this.createScan();
  },
};
</script>


<style scoped> 
main {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 5vw;
}

#qr-code-full-region {
    border-radius: 10px;
    width: 60vw;
    max-width: 600px;
}

@media (max-width: 800px) {
    #qr-code-full-region {
      width: 600px;
      height: 260px;
    }  
}
@media (max-width: 700px) {
    #qr-code-full-region {
      width: 70vw;
      /* height: 260px; */
    }  
}
@media (max-width: 600px) {
    #qr-code-full-region {
      width: 400px;
      height: 260px;
    }  
}
@media (max-width: 500px) {
    #qr-code-full-region {
      width: 400px;
      height: 260px;
    }  
}
@media (max-width: 400px) {
    #qr-code-full-region {
      width: 300px;
      height: 260px;
    }  
}
@media (max-width: 300px) {
    #qr-code-full-region {
      width: 250px;
      height: 260px;
    }  
}
</style>
  
  