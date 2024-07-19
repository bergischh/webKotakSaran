<template>
    <main>
        <div class="container mx-auto py-20">
            <div class="form-login flex flex-col md:flex-row w-8/12 mx-auto shadow-lg">
                <div class="login w-full md:w-1/2 py-16 px-12">
                    <h2 class="text-3xl mb-4 font-bold text-center">Login</h2>
                    <form @submit.prevent="handleSubmit">
                        <div class="mb-2 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 0 1-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 0 0 1.183 1.981l6.478 3.488m8.839 2.51-4.66-2.51m0 0-1.023-.55a2.25 2.25 0 0 0-2.134 0l-1.022.55m0 0-4.661 2.51m16.5 1.615a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V8.844a2.25 2.25 0 0 1 1.183-1.981l7.5-4.039a2.25 2.25 0 0 1 2.134 0l7.5 4.039a2.25 2.25 0 0 1 1.183 1.98V19.5Z" />
                            </svg>
                            <input type="text" placeholder="Email" v-model="email" class="py-2 px-4 w-full ml-2 rounded-lg border-gray-300 focus:outline-none focus:border-indigo-500">
                        </div>
                        <div v-if="errors.email" class="mb-5 flex text-red-500 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-red-600	">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                            </svg>
                            {{ errors.email }}
                        </div>

                        <div class="mb-2 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                            </svg>
                            <input type="password" placeholder="Password" v-model="password" class="py-2 px-4 w-full ml-2 rounded-lg border-gray-300 focus:outline-none focus:border-indigo-500">
                        </div>
                        <div v-if="errors.password" class="flex text-red-500 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-red-600	">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                            </svg>
                            {{ errors.password }}
                        </div>

                        <div class="button-login mt-5 rounded-lg">
                            <button type="submit" class="w-full text-white py-2 bg-black hover:bg-zinc-900 rounded-lg focus:outline-none">Login</button>
                        </div>
                    </form>
                </div>
                <div class="img w-full md:w-1/2 bg-cover bg-center">
                    <img src="../assets/images/suggestion-box.jpg" alt="kotak">
                </div>
                
            </div>
        </div>
    </main>
</template>

<script>
import axios from 'axios';
import {url} from '@/lib/url.js'
export default {
    name: 'Login',
    data() {
        return {
            email: '',
            password: '',
            errors: {},  
        }
    },
    methods: {
        async handleSubmit() {
            this.errors = {}; 
            let isValid = true;

            if (!this.email) {
                this.errors.email = 'Email harus diisi.';
                isValid = false;
            }

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!this.email || !emailPattern.test(this.email)) {
                this.errors.email = 'Format email harus benar.';
                isValid = false;
            }

            if (!this.password) {
                this.errors.password = 'Password harus diisi.';
                isValid = false;
            }

            if (isValid) {
                try {
                    const response = await axios.post(`${url}/login`, {
                        email: this.email,
                        password: this.password
                    });

                    this.$router.push('/dashboard')
                    localStorage.setItem('token', response.data.token.original.token);
                } catch (error) {
                    if (error.response && error.response.status === 401) {
                        this.errors.password = 'Email atau password tidak valid'
                    }
                    console.error(error);
                    // Handle error response from server, if needed
                }
            }
        }
    }
}
</script>

<style lang="scss" scoped>
h2 {
    font-size: 2.5rem;
    margin-bottom: 2rem;
    font-family: "Smooch Sans", sans-serif;
    font-weight: 700;
    font-size: 85px;
}

.login input[type="text"],
.login input[type="password"] {
    transition: all 0.3s;
}

.button-login button {
    transition: background-color 0.3s;
}

@media only screen and (min-width: 768px) {
    .form-login {
        display: flex;
        flex-direction: row;
    }

    .img {
        min-height: unset;
    }
}

@media (max-width: 800px) {
    .form-login {
        width: 100%;
    } 
}
@media (max-width: 700px) {
    .form-login {
        width: 100%;
    }  
}
@media (max-width: 600px) {
    .form-login {
        width: 100%;
    }  
}
@media (max-width: 500px) {
    .form-login {
        width: 100%;
    }  
}
@media (max-width: 400px) {
    .form-login {
        width: 100%;
    }   
}
@media (max-width: 300px) {
    .form-login {
        width: 100%;
    }   
}
</style>