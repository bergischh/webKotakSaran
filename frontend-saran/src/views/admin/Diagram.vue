<template>
    <Sidebar />
        <main>
            <Header />
            <Chart />
        </main>
</template>

<script>
// file admin/diagram.vue
import Chart from '@/components/chart.vue';
import Sidebar from '@/components/Sidebar.vue';
import Header from '@/components/Header.vue';

export default {
    name: 'Diagram',
    components: {
        Sidebar,
        Header,
        Chart,
    }
}
</script>

<style scoped>
.main {
    padding: 2rem;
}

@media (max-width: 768px) {
  main {
    padding-left: 3.9rem;
  }
}
</style>