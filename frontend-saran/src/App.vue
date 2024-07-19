<template>
  <div class="app">
    <router-view></router-view>
  </div>
</template>



<style lang="scss">
:root {
  --white: #fff;
  --primary: rgb(168, 169, 223);
  --grey: #64748b;
  --dark: #9fa7b6;
  --light: #f1f5f9;
  --sidebar-width: 300px;
}
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
body {
  background: var(--light);
}
button {
  cursor: pointer;
  appearance: none;
  border: none;
  outline: none;
  background: none;
}
.app {
  display: flex;
  
  main {
    flex: 1 1 0;
    @media (max-width: 768px) {
    padding-left: 2rem;
  }
  }
}
</style>