<template>
    <div>
        <aside :class="`${is_expanded && 'is_expanded'}`" class="bg-white shadow">
            <div class="menu-toggle-wrap">
                <button class="menu-toggle" @click="ToggleMenu">
                    <span class="material-icons">menu</span>
                </button>
            </div>
            <h3>Menu</h3> 
            <div class="menu">
                <router-link class="button" to="/dashboard">
                    <span class="material-icons">space_dashboard</span>
                    <span class="text">Dashboard</span>
                </router-link>
                <router-link class="button" to="/tempat" :class="{ 'router-link-exact-active': $route.path.includes('/kategori') || $route.path.includes('/generate') } ">
                    <span class="material-icons">qr_code</span>
                    <span class="text">Generate QR</span>
                </router-link>
                <!-- <router-link class="button" to="/test">
                    <span class="material-icons">qr_code</span>
                    <span class="text">Generate QR</span>
                </router-link> -->
            </div>
        </aside>
        
    </div>
</template>

<script setup>
import {ref} from 'vue'
const is_expanded = ref(false)

const ToggleMenu = () => {
    is_expanded.value = !is_expanded.value
}
</script>

<style lang="scss" scoped>

aside {
    flex-direction: column;
    width: calc(2rem + 30px);
    height: 100vh;
    top: 0;
    left: 0;
    overflow: hidden;
    padding: 1rem;
    transition: 0.2s ease-out;
    position: sticky;
    overflow-y: auto;

    .menu-toggle-wrap {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 1rem;
        position: relative;
        top: 0;
        transition: 0.2s ease-out;

        .menu-toggle {
            transition: 0.2s ease-out;
            .material-icons {
                font-size: 2rem;
            }
            &:hover {
                .material-icons {
                    color: var(--primary);
                    transform: translateY(0.5rem);
                }
            }
        }
    }
    h3, .button .text{
        opacity: 0;
        transition: 0.3s ease-out;
    }
    h3 {
        color: var(--dark);
        transition: 0.875rem;
        font-weight: 0.5rem;
        text-transform: uppercase;
    }
    .menu {
        margin: 0 -1rem;

        .button {
            display: flex;
            align-items: center;
            text-decoration: none;

            padding: 0.5rem 1rem;
            transition: 0.2s ease-out;

            .material-icons {
                font-size: 2rem;
                transition: 0.2s ease-out;
            }
            .text {
                transition: 0.2s ease-out;
            }

            &:hover, &.router-link-exact-active{
                background-color: var(--dark);
                
                .material-icons, .text {
                    color: var(--white);
                }
            }
            &.router-link-exact-active {
                border-right: 5px solid var(--primary);
            }
        }
    }
    &.is_expanded {
        width: var(--sidebar-width);

        .menu-toggle-wrap {
            top: -2px;
        }
        h3, .button .text{
        opacity: 1;
        }
        .button {
            .material-icons {
                margin-right: 1rem;
            }
        }
    }

    @media (max-width: 768px) {
        position: fixed;
        z-index: 99;
        width: calc(1.9rem + 30px);
    }
}
</style>