<template>
        <div id="clock" class="flex items-center rounded-lg border border-gray-300 w-56 mx-auto">
            <p class="date px-3 py-2 ">{{ date }}</p>
            <p class="time px-3 py-2">{{ time }}</p>   
        </div>       
</template>

<script type="text/javascript">
export default {
    name: 'Clock',

    data() {
        return {
            date: "0000-00-00",
            time: "00:00:00",
        }
    },
    methods: {
        ShowDTnow:function () {
            const dThisNow = this;
            
            setInterval(function () {

                var tdAten = new Date();
                var months = [
                    "Januari", "Februari", "Maret",
                    "April", "Mei", "Juni",
                    "Juli", "Agustus", "September",
                    "Oktober", "November", "Desember"
                ];

                var monthIndex = tdAten.getMonth();
                var monthName = months[monthIndex];

                dThisNow.date = tdAten.getDate() + " " + monthName + " " + tdAten.getFullYear();
                dThisNow.time = tdAten.getHours() + ":" + tdAten.getMinutes() + ":" + tdAten.getSeconds();
            }, 1000)
        }
    },
    mounted() {
        this.ShowDTnow();
    }
}
</script>