<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import Chart from 'chart.js/auto';
import { ref, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'


const labelName = 'Post Dataset';
const props = defineProps({
    labels: Object,
    data: Object,
});
function chartSet () {
    var ctx = document.getElementById("chart").getContext('2d');
    const myChart = new Chart(ctx, {
        data: {
            datasets: [{
                type: 'bar',
                label: labelName,
                data: props.data
            }],
            labels: props.labels
        },
        
    });
}

onMounted(() => {
  chartSet()
})
</script>

<template>
    <Head title="Dashboard" />

    <AdminLayout>
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-1">
            <div class="md:col-span-2 lg:col-span-1" >
                <div class="h-full py-8 px-6 space-y-6 rounded-xl border border-gray-200 bg-white">
                    <div>
                        <canvas id="chart" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
            
        </div>
    </AdminLayout>
</template>
