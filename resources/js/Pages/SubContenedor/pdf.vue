hola Mundo<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import Swal from 'sweetalert2';
import { walkBlockDeclarations } from '@vue/compiler-core';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    subcontenedores: {type:Object},
    subproductos: {type:Object}
    
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
    fecha:''

    
    

})

const buscarProducto = () =>{
    form.get(route('searchSubContenedor'));
}

const calculateCost = (id) => {
    form.patch(route('subcosto_total', id))
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
            form.delete(route('subcontenedor.destroy', id));
        }
    })
}



</script>

<template>
    <Head title="PDF" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">PDF</h2>
            <div>
                    <input type="text" v-model="form.buscador" class="form-control px-4 py-2 bg-white-800 text-black border rounded-md font-semibold text-xl text-gray-800 leading-tight float-right text-xs"/>
                    <button @click="buscarProducto" type="button" class = "px-4 py-2 bg-gray-800 text-white border rounded-md font-semibold text-xl text-gray-800 leading-tight float-right text-xs">Buscar</button>
            </div>
        </template>     

        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center">
                <Link :href="route('subproducto.create')"
                        :class = "'px-4 py-2 bg-gray-800 text-white border rounded-md font-semibold text-xl text-gray-800 leading-tight text-xs'">
                         <i class="fa-solid fa-plus-circle"></i> Añadir SubProducto
                    </Link>
            </div>
            <div class="bg-white grid v-screen place-items-center">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-4">Name</th>
                            <th class="px-4 py-4">Provedor</th>
                            <th class="px-4 py-4">Valor USD Mercado</th>
                            <th class="px-4 py-4">Costo Total</th>
                            <th class="px-4 py-4">Fecha</th>
                            <th class="px-4 py-4"></th>
                            <th class="px-4 py-4"></th>
                            <th class="px-4 py-4"></th                    
                            >
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="con, i in subcontenedores.data" :key="con.id">
                           <td class="border border-gray-400 px-4 py-4">{{con.name}}</td>
                           <td class="border border-gray-400 px-4 py-4">{{con.provedor}}</td>
                           <td class="border border-gray-400 px-4 py-4">{{con.valorusd_mercado}}</td>
                           <td class="border border-gray-400 px-4 py-4">{{con.costo_contenedor}}</td>
                           <td class="border border-gray-400 px-4 py-4">{{con.fecha}}</td>
                           <td class="border border-gray-400 px-4 py-4" title="Editar Contenedor">
                                <Link :href="route('subcontenedor.edit',con.id)"
                                    :class = "'px-4 py-2 bg-blue-400 text-white border rounded-md font-semibold text-xl text-gray-800 leading-tight text-xs'">
                                    <i class="fa-solid fa-edit"></i> 
                                </Link>
                           </td>
                           <td class="border border-gray-400 px-4 py-4">
                            <PrimaryButton @click="$event => calculateCost(con.id)">
                                <i class="fa-solid fa-dollar"></i>
                            </PrimaryButton>
                           </td> 
                           <td class="border border-gray-400 px-4 py-4" title="Details">
                                    <Link :href="route('subdetalle',con.id)" :class="'px-4 py-2 bg-blue-400 text-white border rounded-md font-semibold text-xl text-gray-800 leading-tight text-xs'">  
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
        </div>
    </AuthenticatedLayout>
</template>
