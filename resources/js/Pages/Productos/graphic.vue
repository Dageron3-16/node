<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import {ref} from 'vue';
import {Bar} from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale,
LinearScale, ArcElement } from 'chart.js';
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement );


const props = defineProps({
    data: {type:Object}
});
const contenedores = ref([]);
const productos = ref([]);
const chartData = ref([]);
const chartOption = ref([]);
const colors = ref([]);

const random = () => {
    return Math.floor(Math.random() * 256);
}
props.data.map((row) => (
    contenedores.value.push(row.id),
    productos.value.push(row.count),
    colors.value.push(("rgb("+random()+","+random()+","+random()+")"))
))
chartOption.value = {responsive:true}
chartData.value = {
    labels:productos.value,
    datasets:[
        {label:'Productos', data:productos.value, backgroundColor:colors}
    ]
}

</script>


<template>
    <Head title="Graphic" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Graphic</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <Bar :data="chartData" :option="chartOption"></Bar>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>