<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import WarningButton from '@/Components/WarningButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { Head,useForm } from '@inertiajs/vue3';
import { nextTick,ref } from 'vue';
import Swal from 'sweetalert2';
import VueTailwindPagination from '@ocrv/vue-tailwind-pagination';



const nameInput = ref(null); 
const modal = ref(false);  
const tittle = ref(''); 
const operation = ref(1);
const id = ref('');


const props = defineProps({
    subproductos: {type:Object},
    subcontenedores: {type:Object}
})
const form = useForm({
    name:'', 
    cant_producto:'',
    cant_cajas:'' 
    
    
});

const buscarProducto = () =>{
    form.get(route('searchSubProducto'));
}

const calcular = (id) => {
    form.patch(route('calcular', id))
}
const formpage = useForm({});
const onePageClick = (event)=>{
    formpage.get(route('subproducto.index', {page:event}))
}
const openModal = (op,name,cant_cajas, subproducto) => {
modal.value = true;
nextTick( () => nameInput.value.focus());
operation.value = op;
id.value = subproducto;
if (op == 1) {
    tittle.value = 'Crear SubProducto';
}
else{
    tittle.value = 'Editar SubProducto';
    form.name=name;
    form.cant_producto=cant_producto;
    form.cant_cajas=cant_cajas;
    
    
}
}
const closeModal = () => {
    modal.value = false;
    form.reset();
}
const save = () => {
    if (operation.value==1) {
        form.post(route('subproducto.store'),{
            onSuccess: () => {ok('SubProducto Añadido al SubContenedor')}
        });
    }
    else{
        form.put(route('subproducto.update', id.value),{
            onSuccess: () => {ok('SubProducto Actualizado')}
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
        title:'Desea Eliminar el SubProducto '+id+' ?',
        icon: 'question', showCancelButton:true,
        confirmButtonText:'<i class = "fa-solid fa-check"></i> Eliminar',
        cancelButtonText: '<i class = "fa-solid fa-ban"></i> Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route('subproducto.destroy', id),{
                onSuccess: () => {ok('SubProducto Eliminado')}
            });
        }
    })
}
</script>

<template>
    <Head title="SubProductos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">SubProducto</h2>
            <div>
                    <input type="text" v-model="form.buscador" class="form-control px-4 py-2 bg-white-800 text-black border rounded-md font-semibold text-xl text-gray-800 leading-tight float-right text-xs"/>
                    <button @click="buscarProducto" type="button" class = "px-4 py-2 bg-gray-800 text-white border rounded-md font-semibold text-xl text-gray-800 leading-tight float-right text-xs">Buscar</button>
            </div>
        </template>

        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center">
                
                
            </div>
            <div class="bg-white grid v-screen place-items-center overflow-x-auto">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-4">#</th>
                            
                            <th class="px-4 py-4">SubContenedor</th>
                            <th class="px-4 py-4">Nombre</th>
                            <th class="px-4 py-4">Cantidad</th>
                            <th class="px-4 py-4">Cantidad de Cajas</th>
                            <th class="px-4 py-4">Precio</th>
                            <th class="px-4 py-4">Precio Total</th>
                            <th class="px-4 py-4"></th>
                            <th class="px-4 py-4"></th>
                            <th class="px-4 py-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="pro, i in subproductos.data" :key="pro.id">
                           <td class="border border-gray-400 px-2 py-2" >{{(i+1)}}</td> 
                           <td class="border border-gray-400 px-2 py-2">{{pro.name_subcontenedor}}</td>
                           <td class="border border-gray-400 px-2 py-2">{{pro.name}}</td>
                           <td class="border border-gray-400 px-2 py-2">{{pro.cant_producto}}</td>
                           <td class="border border-gray-400 px-2 py-2">{{pro.cant_cajas}}</td>
                           <td class="border border-gray-400 px-2 py-2">{{pro.unitario_gastousd}}</td>
                           <td class="border border-gray-400 px-2 py-2">{{pro.precio_total}}</td>
                          
                           
                           <td class="border border-gray-400 px-2 py-2">
                                <WarningButton
                                    @click="$event => openModal(2, pro.name, pro.cant_cajas, pro.id)">
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
             <div class="bg-white grid v-screen place-items-center">
                    <VueTailwindPagination 
                     :current= "subproductos.currentPage" 
                     :total="subproductos.total"
                     :per-page = "subproductos.perPage"
                     @page-changed="$event => onePageClick($event)"
                     >
                     
                    </VueTailwindPagination>
             </div>   
        </div>
        <Modal :show="modal" @close="closeModal">
            <h2 class="p3 text-lg font.medium text-hray-900">{{ tittle }}</h2>
            <div class="p-3 mt-6">
                <InputLabel for="name" value="Nombre del SubProducto:"></InputLabel>
                <TextInput id="name" ref="nameInput"
                v-model="form.name" type="text" class="mt-1 block w-3/4"
                placeholder="name"></TextInput>
                <InputError :message="form.errors.name" class="mt-2"></InputError>
            </div>
            
            <div class="p-3 mt-6">
                <InputLabel for="cant_cajas" value="Cantidad de Cajas:"></InputLabel>
                <TextInput id="cant_cajas" 
                v-model="form.cant_cajas" type="text" class="mt-1 block w-3/4"
                placeholder="Cantidad de Cajas"></TextInput>
                <InputError :message="form.errors.cant_cajas" class="mt-2"></InputError>
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