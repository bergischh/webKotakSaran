<template>
    <div class="container">
        <section>
            <img src="../../assets/images/illustration.svg" alt="illustration">
            <h1>Terima kasih atas kontribusi Anda. Saran Anda sangat berharga bagi kami.</h1>
        </section>
        <router-link  to="/" class="mx-auto text-white bg-indigo-500 py-2 px-3 focus:outline-none hover:bg-indigo-600 rounded text-lg">
            <span>Isi lagi kotak saran?</span>
        </router-link>
    </div>
</template>  

<style lang="scss" scoped>
.container {
    height: 100vh;
    padding-top: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    // background-color: #ffffff;
    font-family: "Roboto", sans-serif;
}

.container {
    max-width: 400px ;
    padding: 2rem;
    margin: auto;
    display: grid;
    color: #333333;
}

.container img {
    width: 440px;
    margin: auto;
}

h1 {
    font-family: "Roboto", sans-serif;
    font-weight: 400;
    font-size: 25px;
}

@media (min-width: 640px) {
    .container {
        max-width: 1200px;
        gap: 2rem;
    }
    .container img {
        max-width: 550px;
    }
}

@media (min-width: 1024px) {
    .container {
        column-gap: 5rem;
    }
}


</style>
