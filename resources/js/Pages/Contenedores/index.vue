<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import Swal from 'sweetalert2';
import { walkBlockDeclarations } from '@vue/compiler-core';
import VueTailwindPagination from '@ocrv/vue-tailwind-pagination';
import exportFromJSON from 'export-from-json'
import { resolveDirective } from 'vue';
const props = defineProps({
    contenedores: {type:Object},
    productos: {type:Object}
    
})

const form = useForm({
    id:'',
    name:'',
    provedor:'',
    valorusd_mercado:'',
    costo_contenedor:'',
    flete:'',
    total_gastousd:'',
    total_gastocup:'',
    costo_contenedor_limpio:'',
    fecha_llegada:'',
    fecha_salida:'',
    tiempo_venta:''

    
    

})
const buscarProducto = () =>{
    form.get(route('searchContenedor'));
}
const formPage = useForm({});

const onPageClick = (event)=>{
    formPage.get(route('contenedor.index', {page:event}));
}
const exportar = () => {
    form.get(route('duplicar', id))
}
const calculateCost = (id) => {
    form.patch(route('costo_total', id))
}
const calculateCostLimpio = (id) => {
    form.patch(route('costo_limpio', id))
}
const  deleteContenedor = (id) => {
    const alerta = Swal.mixin({
        buttonsStyling:true
    })
    alerta.fire({
        title:'Desea Eliminar el contenedor  ?',
        icon: 'question', showCancelButton:true,
        confirmButtonText:'<i class = "fa-solid fa-check"></i> Eliminar',
        cancelButtonText: '<i class = "fa-solid fa-ban"></i> Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route('contenedor.destroy', id));
        }
    })
}



 const exp = () => {
    let timerInterval
Swal.fire({
  title: 'Cargando Contenedor',
  timer: 2000,
  timerProgressBar: true,
  didOpen: () => {
    Swal.showLoading()
    const b = Swal.getHtmlContainer().querySelector('b')
    timerInterval = setInterval(() => {
      b.textContent = Swal.getTimerLeft()
    }, 100)
  },
  willClose: () => {
    clearInterval(timerInterval)
  }
}).then((result) => {
  /* Read more about handling dismissals below */
  if (result.dismiss === Swal.DismissReason.timer) {
    const data = props;
    const fileName = 'Contenedor'
    const exportType =  exportFromJSON.types.json

    exportFromJSON({ data , fileName, exportType })
  }
})
}


</script>

<template>
    <Head title="Contenedores" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Contenedores</h2>
            <div>
                    <input type="text" v-model="form.buscador" class="form-control px-4 py-2 bg-white-800 text-black border rounded-md font-semibold text-xl text-gray-800 leading-tight float-right text-xs"/>
                    <button @click="buscarProducto" type="button" class = "px-4 py-2 bg-gray-800 text-white border rounded-md font-semibold text-xl text-gray-800 leading-tight float-right text-xs">Buscar</button>
            </div>
        </template>     

        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center">
                <div class="mt-3 mb-3 flex">
                    <Link :href="route('contenedor.create')"
                        :class = "'px-4 py-2 bg-gray-800 text-white border rounded-md font-semibold text-xl text-gray-800 leading-tight text-xs'">
                         <i class="fa-solid fa-plus-circle"></i> Añadir
                    </Link>
                    <Link :href="route('file')"
                        :class = "'px-4 py-2 bg-gray-800 text-white border rounded-md font-semibold text-xl text-gray-800 leading-tight text-xs'">
                         <i class="fa-solid "></i> Exportar JSON
                    </Link>
                    <Link :href="route('importar')"
                        :class = "'px-4 py-2 bg-gray-800 text-white border rounded-md font-semibold text-xl text-gray-800 leading-tight text-xs'">
                         <i class="fa-solid "></i> Importar JSON
                    </Link>
                    <Link :href="route('subcontenedor.create')"
                        :class = "'px-4 py-2 bg-gray-800 text-white border rounded-md font-semibold text-xl text-gray-800 leading-tight text-xs'">
                         <i class="fa-solid "></i> Crear SubContenedor
                    </Link>
                   
                   
                        
                  
                </div>
            </div>
            <div class="bg-white grid v-screen place-items-center">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            
                            <th class="px-4 py-4">Numero de Factura</th>
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
                            <th class="px-4 py-4"></th>
                            <th class="px-4 py-4"></th>
                            <th class="px-4 py-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="con, i in contenedores.data" :key="con.id">
                           
                           <td class="border border-gray-400 px-4 py-4">{{con.name}}</td>
                           <td class="border border-gray-400 px-4 py-4">{{con.provedor}}</td>
                           <td class="border border-gray-400 px-4 py-4">{{con.valorusd_mercado}}</td>
                           <td class="border border-gray-400 px-4 py-4">{{con.costo_contenedor}}</td>
                           <td class="border border-gray-400 px-4 py-4">{{con.flete}}</td>
                           <td class="border border-gray-400 px-4 py-4">{{con.costo_contenedor_limpio}}</td>
                           <td class="border border-gray-400 px-4 py-4">{{con.total_gastousd}}</td>
                           <td class="border border-gray-400 px-4 py-4">{{con.total_gastocup}}</td>
                           <td class="border border-gray-400 px-4 py-4">{{con.fecha_llegada}}</td>
                           <td class="border border-gray-400 px-4 py-4">{{con.fecha_salida}}</td>
                           <td class="border border-gray-400 px-4 py-4">{{con.tiempo_venta}}</td>
                           <td class="border border-gray-400 px-4 py-4" title="Editar Contenedor">
                                <Link :href="route('contenedor.edit',con.id)"
                                    :class = "'px-4 py-2 bg-blue-400 text-white border rounded-md font-semibold text-xl text-gray-800 leading-tight text-xs'">
                                    <i class="fa-solid fa-edit"></i> 
                                </Link>
                           </td>
                            <td class="border border-gray-400 px-4 py-4" title="Total de gasto">
                                <PrimaryButton @click="$event => calculateCost(con.id)" :class="'px-4 py-2 bg-blue-400 text-white border rounded-md font-semibold text-xl text-gray-800 leading-tight text-xs'">  
                                    <i class="fa-solid fa-dollar"></i>
                                </PrimaryButton>
                           </td>
                           <td class="border border-gray-400 px-4 py-4" title="Duplicar Contendenor">
                                    <Link :href="route('editar',con.id)" :class="'px-4 py-2 bg-blue-400 text-white border rounded-md font-semibold text-xl text-gray-800 leading-tight text-xs'">  
                                       <i class="fa-solid fa-clipboard"></i>                                                                  
                                     
                                    </Link>
                           </td>
                           
                           <td class="border border-gray-400 px-4 py-4" title="Details">
                                    <Link :href="route('detalle',con.id)" :class="'px-4 py-2 bg-blue-400 text-white border rounded-md font-semibold text-xl text-gray-800 leading-tight text-xs'">  
                                       <i class="fa-solid fa-book"></i>                                                                  
                                     
                                    </Link>
                           </td>

                           <td class="border border-gray-400 px-4 py-4">
                            <DangerButton @click="$event => deleteContenedor(con.id)">
                                <i class="fa-solid fa-trash"></i>
                            </DangerButton>
                           </td>
                           
                        </tr>
                    </tbody>
                </table>
            
            </div> 
            <div class="bg-white grid v-screen place-items-center">
                <VueTailwindPagination 
                     :current= "contenedores.currentPage" 
                     :total="contenedores.total"
                     :per-page = "contenedores.perPage"
                     @page-changed="$event => onPageClick($event)"
                ></VueTailwindPagination>
             </div>   
        </div>
    </AuthenticatedLayout>
</template>
