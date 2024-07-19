<template>
    <div class="chartCard">
        <div class="chartBox drop-shadow-lg">
            <canvas id="myChart"></canvas>
        </div>
    </div>
</template>

<!-- <script setup lang="ts">
// file components/chart.vue

import Chart, { ChartConfiguration, ChartItem } from 'chart.js/auto';
import { onMounted, ref } from 'vue';
import axios from 'axios';
import { urlapi } from '@/lib/url';

// const labels = ref([]);
// const counts = ref([]);
// const backgroundColors = ref([]);

const chartRef = ref([]);
let myChart = null;

onMounted(() => {
    const ctx = chartRef.value.getContext('2d');
    myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: props.labels,
            datasets: [{
                data: props.counts, //value dari data
                label: 'Data Saran Berdasarkan Penempatan', //label = nama penempatan
                backgroundColor: props.backgroundColors, //warna data dari nama penempatan
                borderColor: 'rgb(255, 99, 132)',
            },]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
            y: {
            beginAtZero: true
            }
        }
        },

    })
})

onMounted(() => {
    if (myChart) {
        myChart.destroy()
    }
})

{chartRef}
</script> -->

<script setup lang="ts">
// file components/chart.vue

import Chart, { ChartConfiguration, ChartItem } from 'chart.js/auto';
import { onMounted } from 'vue';
import axios from 'axios';
import { urlapi } from '@/lib/url';

const labels = [];
const counts = [];
const backgroundColors = [];

const data = {
    labels: labels,
    datasets: [{
        data: counts, //value dari data
        label: 'Data Saran Berdasarkan Penempatan', //label = nama penempatan
        backgroundColor: backgroundColors, //warna data dari nama penempatan
        borderColor: 'rgb(255, 99, 132)',
    },]
};

const config: ChartConfiguration = {
    type: 'bar',
    data: data,
    options: {
        maintainAspectRatio: false,
        scales: {
        y: {
          beginAtZero: true
        }
      }
    },
};
onMounted(async () => {
    const canvasTag = <ChartItem>document.getElementById('myChart');
    const response = await axios.get(`${urlapi}/data/chart`,{
        headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
        }
    });

    if (response.data.success) {
        const penempatanCount = {};

        response.data.data.forEach( (item: any) => {
            const namaPenempatan = item.nama_penempatan;
            if (!penempatanCount[namaPenempatan]) {
                penempatanCount[namaPenempatan] = 1;
            }else {
                penempatanCount[namaPenempatan]++;
            }
        });

        for(const [namaPenempatan, count] of Object.entries(penempatanCount)) {
            labels.push(namaPenempatan);
            counts.push(count);
            backgroundColors.push(getRandomColor());
        }

        new Chart(
            canvasTag,
            config
        );
    }
});

function getRandomColor() {
    const color1 = Math.floor(Math.random() * 156) + 100;
    const color2 = Math.floor(Math.random() * 156) + 100;
    const color3 = Math.floor(Math.random() * 156) + 100;
    
    return `rgb( ${color3}, ${color1}, ${color2})`; 
}

</script>


<style scoped>
.chartCard {
    width: auto; /*100vw */
    height: calc(255, 26, 104, 0.2);
    display: flex;
    margin-left: 1rem;
    align-items: center;
    justify-content: center;
}

.chartBox {
    width: 900px;
    height: 350px;
    padding: 20px;
    border-radius: 20px;
    border: solid 3px #B5C0D0;
    background: white;
}

@media only screen and (max-width: 700px){
    .chartBox {
        width: 90%;
        height: 45%;
    }
}
@media only screen and (max-width: 400px){
    .chartBox {
        width: 300px;
        height: 300px;
        margin-left: -50rem;
    }
}
@media only screen and (max-width: 300px){
    .chartBox {
        width: 200px;
        height: 200px;
        padding: 20px;
    }

    
}
</style>

