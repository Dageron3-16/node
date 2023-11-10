<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

import WarningButton from '@/Components/WarningButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { Head,useForm } from '@inertiajs/vue3';
import { nextTick,ref } from 'vue';
import Swal from 'sweetalert2';




const nameInput = ref(null); 
const modal = ref(false);  
const tittle = ref(''); 
const operation = ref(1);
const id = ref('');


const props = defineProps({
    productos: {type:Object},
    contenedores: {type:Object},
    ventas: {type:Object}
})
const form = useForm({
    venta_propuesta:''
    
    
});






const openModal = (op,venta_propuesta, producto) => {
modal.value = true;
nextTick( () => nameInput.value.focus());
operation.value = op;
id.value = producto;
if (op == 1) {
    tittle.value = 'Crear Producto';
}
else{
    tittle.value = 'Editar Venta';
    form.valorusd_mercado = valorusd_mercado;
    form.venta_propuesta=venta_propuesta;
    
}
}
const dato = (id) => {
    form.get(route('datos'))
}
const closeModal = () => {
    modal.value = false;
    form.reset();
}
const save = () => {
    if (operation.value==1) {
        form.post(route('productos.store'),{
            onSuccess: () => {ok('Producto Añadido al Contenedor')}
        });
    }
    else{
        form.put(route('ventas.update', id.value),{
            onSuccess: () => {ok('Venta Actualizada')}
        });
    }
}
const ok = (msj) => {
    form.reset();
    closeModal();
    Swal.fire({title:msj,icon:'success'});
}
const  deleteProducto = (id) => {
    const alerta = Swal.mixin({
        buttonsStyling:true
    })
    alerta.fire({
        title:'Desea Eliminar el Producto '+id+' ?',
        icon: 'question', showCancelButton:true,
        confirmButtonText:'<i class = "fa-solid fa-check"></i> Eliminar',
        cancelButtonText: '<i class = "fa-solid fa-ban"></i> Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route('ventas.destroy', id),{
                onSuccess: () => {ok('Producto Eliminado')}
            });
        }
    })
}
</script>

<template>
    <Head title="Productos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Precio Venta</h2>
        </template>

        <div class="py-12">
            
            <div class="bg-white grid v-screen place-items-center overflow-x-auto">
                <div class="mt-3 mb-3 flex">
                    <Button @click="$event => dato()" class = "px-4 py-2 bg-gray-800 text-white border rounded-md font-semibold text-xl text-gray-800 leading-tight text-xs">
                        <i class="fa-solid fa-plus-circle"></i>Añadir Venta
                    </Button>
                </div>
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-4">#</th>
                            <th class="px-4 py-4">Contenedores</th>
                            <th class="px-4 py-4">Nombre del Producto</th>
                            <th class="px-4 py-4">Valor CUP del producto</th>
                            <th class="px-4 py-4">Venta propuesta</th>
                            <th class="px-4 py-4">Porciento de Ganancia</th>
                            <th class="px-4 py-4">Precio Venta</th>
                            
                            <th class="px-4 py-4"></th>
                            <th class="px-4 py-4"></th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="pro, i in ventas" :key="pro.id">
                           <td class="border border-gray-400 px-2 py-2">{{(i+1)}}</td> 
                           <td class="border border-gray-400 px-2 py-2">Contenedor {{pro.contenedores_id}}</td>
                           <td class="border border-gray-400 px-2 py-2">{{pro.name}}</td>
                           <td class="border border-gray-400 px-2 py-2">{{pro.valorcup_producto}}</td>
                           <td class="border border-gray-400 px-2 py-2">{{pro.venta_propuesta}}</td>
                           <td class="border border-gray-400 px-2 py-2">{{pro.porciento_ganancia}}</td>
                           <td class="border border-gray-400 px-2 py-2">{{pro.precio_venta}}</td>
                           <td class="border border-gray-400 px-2 py-2">
                                <WarningButton
                                    @click="$event => openModal(2,pro.venta_propuesta,pro.id)">
                                    <i class="fa-solid fa-edit"></i>
                                </WarningButton>
                            
                           </td>
                           <td class="border border-gray-400 px-2 py-2">
                            <DangerButton @click="$event => deleteProducto(pro.id)">
                                <i class="fa-solid fa-trash"></i>
                            </DangerButton>
                           </td>
                        </tr>
                    </tbody>
                </table>
             </div>    
        </div>
        <Modal :show="modal" @close="closeModal">
            <h2 class="p3 text-lg font.medium text-hray-900">{{ tittle }}</h2>
            
            <div class="p-3 mt-6">
                <InputLabel for="venta_propuesta" value="Propuesta de Precio:"></InputLabel>
                <TextInput id="venta_propuesta" ref="nameInput"
                v-model="form.venta_propuesta" type="text" class="mt-1 block w-3/4"
                placeholder="valor"></TextInput>
                <InputError :message="form.errors.venta_propuesta" class="mt-2"></InputError>
            </div>
            
            <div class="p-3 mt-6">
                <PrimaryButton class="ml-3" :disable="form.processing" @click="save">
                    <i class="fa-solid fa-save"></i> Aceptar
                </PrimaryButton>
            </div>
            <div class="p-3 mt-6 flex justify-end">
                <SecondaryButton class="ml-3" :disable="form.processing" @click="closeModal">
                    <i class="fa-solid"></i> Cancelar
                </SecondaryButton>
            </div>
        </Modal>
       
    </AuthenticatedLayout>
</template>