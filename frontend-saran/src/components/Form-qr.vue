<template> 
      <div class="main-content">
          <div class="tabs">
              <div class="menu">
                  <router-link to="/tempat" class="menu-item" exact>
                    <span>Penempatan</span>
                  </router-link>

                  <router-link to="/kategori" class="menu-item" exact>              
                    <span>Kategori</span>
                  </router-link>

                  <router-link to="/generate" class="menu-item" exact>
                    <span>Generate QR</span>
                  </router-link>
              </div>
          </div>   
      </div> 
</template>


<script>
import Sidebar from '@/components/Sidebar.vue'
import Header from '@/components/Header.vue'
export default {
  data() {
      return {

      }
  },
  components: {
      Sidebar,
      Header,
  }
}
</script>

<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
.main-content {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
  width: 100%;
  max-width: 100%; 
  overflow-x: auto; 
}
.tabs {
  border-radius: 10px;
  border: 1px solid #e3e3e3;
  font-family: "Roboto", sans-serif;
  background-color: white;
  overflow: hidden;
  width: 100%; 
  max-width: 100%; 
}

.tabs .menu {
  display: flex;
  flex-wrap: wrap;
  border-bottom: 2px solid #ddd;
}

.tabs .menu-item {
  flex: 1;
  padding: 16px;
  font-size: 15px;
  font-weight: 400;
  background-color: rgb(165 180 252);
  letter-spacing: 0.8px;
  text-transform: uppercase;
  text-align: center;
  box-shadow: 0 2px 0 transparent;
  cursor: pointer;
  transition: 0.3s;
}

.tabs .menu-item.router-link-exact-active {
  border-bottom: 2px solid #000;
  background: rgb(199 210 254);

}

.tabs .menu-item:hover {
  background: rgb(199 210 254);
}

@media (max-width: 768px) {
main {
  padding-left: 3.9rem;
}
}
</style>

