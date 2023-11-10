<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import {ref} from 'vue';
import InputLabel from '@/Components/InputLabel.vue';
import SelectInput from '@/Components/SelectInput.vue';
import DataTable from 'datatables.net-vue3';
import 'datatables.net-dt/css/jquery.dataTables.css';
import ButtonHtml5 from 'datatables.net-buttons/js/buttons.html5';
import 'datatables.net-buttons/js/buttons.print';
import 'datatables.net-responsive-dt';
import 'datatables.net-responsive-dt/css/responsive.dataTables.min.css';
import JsZip from 'jszip';
import pdfmake from "pdfmake/build/pdfmake";
import * as pdfFonts from 'pdfmake/build/vfs_fonts';
pdfmake.vfs = pdfFonts.pdfmake ? pdfFonts.pdfMake.vfs : pdfmake.vfs;
window.JSZip = JsZip;

DataTable.use(pdfmake);
DataTable.use(ButtonHtml5);

const props = defineProps({
    productos: {type:Object}, contenedores: {type:Object}, gastosusd: {type:Object}, gastoscup: {type:Object}, ventas: {types:Object}, 
    subproductos :{type:Object}, subcontenedores:{type:Object}
});
const columns1 = ref([]);
const columns2 = ref([]);
const columns3 = ref([]);
const columns4 = ref([]);
const columns5 = ref([]);
const columns6 = ref([]);
const columns7 = ref([]);
const buttons1 = ref([]);
const buttons2 = ref([]);
const buttons3 = ref([]);
const buttons4 = ref([]);
const buttons5 = ref([]);
const buttons6 = ref([]);
const buttons7 = ref([]);
const reporte = ref('2'); 
const types = ref([{'id' : '1', 'name':'Productos'},{'id':'2','name':'Contenedores'},{'id':'3','name':'Gastos USD'},{'id':'4','name':'Gastos CUP'},{'id':'5','name':'Precios'},{'id' : '6', 'name':'SubProductos'},{'id':'7','name':'SubContenedores'}]);
 
columns1.value = [{data:null, render:function(data,type,row,meta)
    {return (meta.row + 1)}},
    {data:'factura'},
    {data:'name'},
    {data:'cod_producto'},
    {data:'cant_producto'},
    {data:'cant_cajas'},
    {data:'precio_caja'},
    {data:'precio_total'},
    {data:'precio_unitariousd'},
    {data:'porciento_total'},
    {data:'costo_flete'},
    {data:'total_gastousd'},
    {data:'unitario_gastousd'}
]
columns2.value = [{data:null, render:function(data,type,row,meta)
    {return (meta.row + 1)}},
    {data:'name'},
    {data:'provedor'},
    {data:'valorusd_mercado'},
    {data:'costo_contenedor'},
    {data:'flete'},
    {data:'costo_contenedor_limpio'},
    {data:'fecha_llegada'},
    {data:'fecha_salida'},
    {data:'tiempo_venta'}
    
]  
columns3.value = [{data:null, render:function(data,type,row,meta)
    {return (meta.row + 1)}},
    {data:'contenedores_id'},
    {data:'nombre_gastousd'},
    {data:'valor_gastousd'}
    
]  
columns4.value = [{data:null, render:function(data,type,row,meta)
    {return (meta.row + 1)}},
    {data:'contenedores_id'},
    {data:'nombre_gastocup'},
    {data:'valor_gastocup'}
    
]
columns5.value = [{data:null, render:function(data,type,row,meta)
    {return (meta.row + 1)}},
    {data:'name'},
    {data:'valorcup_producto'},
    {data:'venta_propuesta'},
    {data:'porciento_ganancia'},
    {data:'precio_venta'},
    {data:'valorusd_mercado'}
    
]
columns6.value = [{data:null, render:function(data,type,row,meta)
    {return (meta.row + 1)}},
    {data:'name_subcontenedor'},
    {data:'name'},
    {data:'cod_producto'},
    {data:'cant_producto'},
    {data:'cant_cajas'},
    {data:'unitario_gastousd'},
    {data:'precio_total'},
   
]
columns7.value = [{data:null, render:function(data,type,row,meta)
    {return (meta.row + 1)}},
    {data:'id'},
    {data:'name'},
    {data:'provedor'},
    {data:'costo_contenedor'},
    {data:'valorusd_mercado'},
    {data:'fecha'}
    
    
]
buttons1.value = [
   {
        tittle:'Productos', extend: 'excelHtml5',
        text: '<i class = "fa-solid fa-file-excel"></i>Excel',
        className:'inline-flex items-center px-4 py-2 bg-green-600 border border-trasnsparent rounded-md font-semibold text-xs text-white-700 uppercase tracking-widest shadow-sm hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150'
   },
   {
        tittle:'Productos',extend: 'pdfHtml5',
        text: '<i class = "fa-solid fa-file-pdf"></i>PDF',
        className:'inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150'
   },
]
buttons2.value = [
   {
        tittle:'Contenedores', extend: 'excelHtml5',
        text: '<i class = "fa-solid fa-file-excel"></i>Excel',
        className:'inline-flex items-center px-4 py-2 bg-green-600 border border-trasnsparent rounded-md font-semibold text-xs text-white-700 uppercase tracking-widest shadow-sm hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150'
   },
   {
        tittle:'Productos', extend: 'pdfHtml5',
        text: '<i class = "fa-solid fa-file-pdf"></i>PDF',
        className:'inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150'
   },
]
buttons3.value = [
   {
        tittle:'Contenedores', extend: 'excelHtml5',
        text: '<i class = "fa-solid fa-file-excel"></i>Excel',
        className:'inline-flex items-center px-4 py-2 bg-green-600 border border-trasnsparent rounded-md font-semibold text-xs text-white-700 uppercase tracking-widest shadow-sm hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150'
   },
   {
        tittle:'Productos', extend: 'pdfHtml5',
        text: '<i class = "fa-solid fa-file-pdf"></i>PDF',
        className:'inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150'
   },
]
buttons4.value = [
   {
        tittle:'Contenedores', extend: 'excelHtml5',
        text: '<i class = "fa-solid fa-file-excel"></i>Excel',
        className:'inline-flex items-center px-4 py-2 bg-green-600 border border-trasnsparent rounded-md font-semibold text-xs text-white-700 uppercase tracking-widest shadow-sm hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150'
   },
   {
        tittle:'Productos', extend: 'pdfHtml5',
        text: '<i class = "fa-solid fa-file-pdf"></i>PDF',
        className:'inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150'
   },
]
buttons5.value = [
   {
        tittle:'Contenedores', extend: 'excelHtml5',
        text: '<i class = "fa-solid fa-file-excel"></i>Excel',
        className:'inline-flex items-center px-4 py-2 bg-green-600 border border-trasnsparent rounded-md font-semibold text-xs text-white-700 uppercase tracking-widest shadow-sm hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150'
   },
   {
        tittle:'Productos', extend: 'pdfHtml5',
        text: '<i class = "fa-solid fa-file-pdf"></i>PDF',
        className:'inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150'
   },
]

buttons6.value = [
   {
        tittle:'Contenedores', extend: 'excelHtml5',
        text: '<i class = "fa-solid fa-file-excel"></i>Excel',
        className:'inline-flex items-center px-4 py-2 bg-green-600 border border-trasnsparent rounded-md font-semibold text-xs text-white-700 uppercase tracking-widest shadow-sm hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150'
   },
   {
        tittle:'Productos', extend: 'pdfHtml5',
        text: '<i class = "fa-solid fa-file-pdf"></i>PDF',
        className:'inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150'
   },
]
buttons7.value = [
   {
        tittle:'Contenedores', extend: 'excelHtml5',
        text: '<i class = "fa-solid fa-file-excel"></i>Excel',
        className:'inline-flex items-center px-4 py-2 bg-green-600 border border-trasnsparent rounded-md font-semibold text-xs text-white-700 uppercase tracking-widest shadow-sm hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150'
   },
   {
        tittle:'Productos', extend: 'pdfHtml5',
        text: '<i class = "fa-solid fa-file-pdf"></i>PDF',
        className:'inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150'
   },
]
</script>


<template>
    <Head title="SubContenedor" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reporte</h2>
            
        </template>
         
        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                
                <div class="px-6 py-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    
                    <InputLabel for="rep" Value="Reporte:"></InputLabel>
                    
                    <SelectInput id="rep" class="mt-1 block w-3/4"
                    v-model="reporte" :options="types"></SelectInput>
                    
                </div>
                
                <div v-if="reporte == '1'" class="px-6 py-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    
                    <DataTable :data="productos" :columns="columns1"
                    class="w-full border border-gray-400"
                    :options="{responsive:true, autoWidth:false,dom:'Bftrip',buttons:buttons1}">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-4">#</th>
                            <th class="px-4 py-4">Contenedor</th>
                            <th class="px-4 py-4">Nombre</th>
                            <th class="px-4 py-4">Codigo del Producto</th>
                            <th class="px-4 py-4">Cantidad</th>
                            <th class="px-4 py-4">Cantidad de Cajas</th>
                            <th class="px-4 py-4">Precio por Caja</th>
                            <th class="px-4 py-4">Precio Total</th>
                            <th class="px-4 py-4">Precio Unitario USD</th>
                            <th class="px-4 py-4">Porciento del Total</th>
                            <th class="px-4 py-4">Flete del Producto</th>
                            <th class="px-4 py-4">Total con Gastos</th>
                            <th class="px-4 py-4">Unitario con Gastos</th>
                            
                        </tr>
                    </thead>
                    </DataTable>
                </div>
                <div v-if="reporte == '2'" class="px-6 py-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <DataTable :data="contenedores" :columns="columns2"
                    class="w-full border border-gray-400"
                    :options="{responsive:true, autoWidth:false,dom:'Bftrip',buttons:buttons2}">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-4">#</th>
                            <th class="px-4 py-4">Contenedor</th>
                            <th class="px-4 py-4">Provedor</th>
                            <th class="px-4 py-4">Valor USD Mercado</th>
                            <th class="px-4 py-4">Costo del contenedor</th>
                            <th class="px-4 py-4">Flete</th>
                            <th class="px-4 py-4">Costo limpio</th>
                            <th class="px-4 py-4">Total de Gasto USD</th>
                            <th class="px-4 py-4">Total de Gasto CUP</th>
                            <th class="px-4 py-4">Fecha Llegada</th>
                            <th class="px-4 py-4">Fecha Salida</th>
                            <th class="px-4 py-4">Tiempo de venta</th>
                            
                        </tr>
                    </thead>
                    
                    </DataTable>
                </div>
                <div v-else-if="reporte == '3'" class="px-6 py-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <DataTable :data="gastosusd" :columns="columns3"
                    class="w-full border border-gray-400"
                    :options="{responsive:true, autoWidth:false,dom:'Bftrip',buttons:buttons3}">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-4">#</th>
                            <th class="px-4 py-4">Contenedor</th>
                            <th class="px-4 py-4">Nombre del Gasto</th>
                            <th class="px-4 py-4">Valor</th>
                            
                        </tr>
                        
                    </thead>
                    
                    </DataTable>
                    
                </div>
                <div v-if="reporte == '4'" class="px-6 py-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <DataTable :data="gastoscup" :columns="columns4"
                    class="w-full border border-gray-400"
                    :options="{responsive:true, autoWidth:false,dom:'Bftrip',buttons:buttons4}">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-4">#</th>
                            <th class="px-4 py-4">Contenedor</th>
                            <th class="px-4 py-4">Nombre del Gasto</th>
                            <th class="px-4 py-4">Valor</th>
                            
                        </tr>
                        
                    </thead>
                    
                    </DataTable>
                    
                </div>
                <div v-else-if="reporte == '5'" class="px-6 py-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <DataTable :data="ventas" :columns="columns5"
                    class="w-full border border-gray-400"
                    :options="{responsive:true, autoWidth:false,dom:'Bftrip',buttons:buttons5}">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-4">#</th>
                            <th class="px-4 py-4">Nombre del Producto</th>
                            <th class="px-4 py-4">Valor CUP del producto</th>
                            <th class="px-4 py-4">Venta propuesta</th>
                            <th class="px-4 py-4">Porciento de Ganancia</th>
                            <th class="px-4 py-4">Precio Venta</th>
                            <th class="px-4 py-4">USD en el Mercado</th>
                            
                        </tr>
                        
                    </thead>
                    
                    </DataTable>
                    
                </div>
                <div v-if="reporte == '6'" class="px-6 py-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    
                    <DataTable :data="subproductos" :columns="columns6"
                    class="w-full border border-gray-400"
                    :options="{responsive:true, autoWidth:false,dom:'Bftrip',buttons:buttons6}">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-4">#</th>
                            <th class="px-4 py-4">SubContenedor</th>
                            <th class="px-4 py-4">Nombre</th>
                            <th class="px-4 py-4">Codigo del Producto</th>
                            <th class="px-4 py-4">Cantidad Producto</th>
                            <th class="px-4 py-4">Cantidad de Canjas</th>
                            <th class="px-4 py-4">Precio</th>
                            <th class="px-4 py-4">Precio Total</th>
                            
                            
                        </tr>
                    </thead>
                    </DataTable>
                </div>
                <div v-if="reporte == '7'" class="px-6 py-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <DataTable :data="subcontenedores" :columns="columns7"
                    class="w-full border border-gray-400"
                    :options="{responsive:true, autoWidth:false,dom:'Bftrip',buttons:buttons7}">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-4">#</th>
                            <th class="px-4 py-4">Contenedores</th>
                            <th class="px-4 py-4">Factura</th>
                            <th class="px-4 py-4">Provedor</th>
                            <th class="px-4 py-4">Costo del contenedor</th>
                            <th class="px-4 py-4">Valor Usd Mercado</th>
                            <th class="px-4 py-4">Fecha</th>
                            
                            
                        </tr>
                    </thead>
                    
                    </DataTable>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>