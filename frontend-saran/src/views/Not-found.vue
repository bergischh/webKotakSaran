.
<template>
    <div class="container">
        <div class="header">
            <h1>404</h1>
            <h3>Page Not Found</h3>
        </div>
        <img src="../assets/images/img-404.jpg" alt="not found">
        <div class="footer">
            <p>Maaf, halaman yang kamu tuju tidak bisa ditemukan. Tolong kembali ke halaman sebelumnya</p>
            <div class="button">
                <router-link  to="/">
                    <span>KEMBALI</span>
                </router-link>
            </div>
        </div>
    </div>
</template>

<style scoped>
* {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}
.container {
    height: 100vh;
    padding-top: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #ffffff;
    font-family: "Roboto", sans-serif;
}

.container {
    max-width: 400px;
    padding: 2rem;
    margin: auto;
    display: grid;
    color: #333333;
}

.header {
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
}

.header h1 {
    font-size: 4rem;
    font-weight: 900;
}

.container h3 {
    font-size: 2rem;
    font-weight: 900;
}

.container img {
    width: 100%;
    max-width: 300px;
    margin: auto;
}

.footer {
    display: grid;
    gap: 2rem;
    place-content: baseline;
}

.footer p {
    font-variation-settings: 1rem;
}

.footer .button{
    padding: 0.7rem;
    outline: none;
    border: none;
    border-radius: 5px;
    color: #ffffff;
    font-size: 1rem;
    font-weight: 600;
    background-color: rgb(129 140 248);
    cursor: pointer;
    transition: .3s;
}

.footer .button:hover {
    background-color: rgb(99 102 241);
}

@media (min-width: 640px) {
    .container {
        max-width: 1200px;
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
    }
    .container img {
        max-width: 550px;
        grid-area: 1/1/3/2;
    }
    .footer {
        max-width: 300px;
    }
}

@media (min-width: 1024px) {
    .container {
        column-gap: 5rem;
    }

    .header h1 {
        font-size: 6rem;
    }
    
    .header h3 {
        font-size: 2.5rem;
    }
}

</style> 
