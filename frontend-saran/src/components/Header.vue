<template>
    <div class="header flex-1 mb-10">
            <!-- header -->
            <div class="bg-white shadow px-2 py-2 flex">
                <router-link to="/dashboard" class="flex left-3 items-center">
                    <img src="../assets/images/box.svg" alt="" class="w-9 h-9">
                    <span class="font-bold text-lg">Kotak Saran</span>
                </router-link>

                <div class="profile">
                    <button class="flex right-0 absolute items-center" @click="toggleVisibility">
                        <span class="font-bold text-lg">Halo, Admin</span>
                        <img src="../assets/images/profile.avif" alt="" class="w-9 h-9">
                    </button>
                    <div v-if="isVisble" @click="handleLogout" class="absolute w-48 mt-10 right-0 bg-white shadow-xl z-20 rounded-lg">
                        <router-link class="block px-4 py-2 text-sm capitalize text-gray-700 rounded-lg hover:bg-indigo-400 hover:text-white flex" to="">
                            <span class="material-icons">logout</span>
                            <span class="text mb-1 ml-1 text-base font-semibold	">Logout</span>
                        </router-link>
                    </div>

                </div>
            </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isVisble:false,
        };
    },
    methods: {
        toggleVisibility() {
            this.isVisble = !this.isVisble;
        },
        handleLogout() {
            localStorage.removeItem('token');
            this.$router.push('/loginAdmin')
        }
    }
};
</script>
