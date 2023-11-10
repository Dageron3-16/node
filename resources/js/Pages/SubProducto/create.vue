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


const formPage = useForm({});
const onPageClick = (event)=>{
    
    formPage.get(route('subproducto.create', {page:event}));
}
const props = defineProps({
    subproductos: {type:Object},
    productos: {type:Object},
    newproductos:{type:Object},
    contenedores: {type:Object},
    subcontenedores: {type:Object},
    search_producto: {type:Object}

})
const form = useForm({
    id:'',
    contenedores_id:'',
    name:'',
    cant_cajas:'',
    cant_producto:'',
    subcontenedor_id:'',
    buscador:'',
    
    
});
const closeModal = () => {
    modal.value = false;
    form.reset();
}
const openModal = (op,producto) => {
modal.value = true;
nextTick( () => nameInput.value.focus());
tittle.value = 'SubContenedor al que pertenece';
id.value = producto;

const correcto = (msj) => {
    form.reset();
    closeModal();
    Swal.fire({title:msj,icon:'success'});
}

}
const save = (id) =>{
    
    form.get(route('Adicionar', id),{
            onSuccess: () => {Swal.fire({title:'SubProducto Añadido al Contenedor',icon:'success'})}
        });
}
const PalabraClave = () =>{
    form.get(route('searchSubProductoCreate'));
}
 
  


</script>

<template>
    <Head title="Agregar SubProductos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Agregar SubProducto</h2>
            <div>
                    <input type="text" v-model="form.buscador" class="form-control px-4 py-2 bg-white-800 text-black border rounded-md font-semibold text-xl text-gray-800 leading-tight float-right text-xs"/>
                    <button @click="PalabraClave" type="button" class = "px-4 py-2 bg-gray-800 text-white border rounded-md font-semibold text-xl text-gray-800 leading-tight float-right text-xs">Buscar</button>
            </div>
        </template>

        <div class="py-12">
            <form @submit.prevent="$event => form.get(route('subproducto.create'))" class="mt-6 space max-w-xl">  
                
                <InputLabel for="contenedores_id" value="Contenedor:"></InputLabel>
                <SelectInput id="contenedores_id" :options="contenedores" type="text" class="mt-1 block w-3/4"
                placeholder="contenedores_id" v-model="form.contenedores_id" autofocus required ></SelectInput>           
                <PrimaryButton :disabled="form.processing">
                    <i class="fa-solid fa-circle-plus"></i> Filtrar 
                </PrimaryButton>
                
             
            </form>  
            <div class="bg-white grid v-screen place-items-center overflow-x-auto">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-4">#</th>
                            <th class="px-4 py-4">Factura</th>
                            <th class="px-4 py-4">Codigo de Producto</th>
                            <th class="px-4 py-4">Nombre</th>
                            <th class="px-4 py-4">Cantidad</th>
                            <th class="px-4 py-4">Precio por Caja</th>
                            <th class="px-4 py-4">Precio Total</th>
                            <th class="px-4 py-4"></th>
                            <th class="px-4 py-4"></th>
                            <th class="px-4 py-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="pro, i in newproductos.data" :key="pro.id">
                           <td class="border border-gray-400 px-2 py-2">{{(i+1)}}</td> 
                           <td class="border border-gray-400 px-2 py-2">{{pro.factura}}</td>
                           <td class="border border-gray-400 px-2 py-2">{{pro.cod_producto}}</td>
                           <td class="border border-gray-400 px-2 py-2">{{pro.name}}</td>
                           <td class="border border-gray-400 px-2 py-2">{{pro.cant_cajas}}</td>
                           <td class="border border-gray-400 px-2 py-2">{{pro.unitario_gastousd}}</td>
                           <td class="border border-gray-400 px-2 py-2">{{pro.precio_total}}</td>
                           
                           
                           
                           
                           
                           <td class="border border-gray-400 px-2 py-2">
                            <PrimaryButton
                                    @click="$event => openModal(1,pro.id)">
                                    <i class="fa-solid fa-plus"></i>
                            </PrimaryButton>
                           </td>
                        </tr>
                    </tbody>
                </table>
             </div> 
             
            
            <div class="bg-white grid v-screen place-items-center">
                <VueTailwindPagination 
                     :current= "newproductos.currentPage" 
                     :total="newproductos.total"
                     :per-page = "newproductos.perPage"
                     @page-changed="$event => onPageClick($event)"
                ></VueTailwindPagination>
             </div>
        </div>
        
        <Modal :show="modal" @close="closeModal">
            <h2 class="p3 text-lg font.medium text-hray-900">{{ tittle }}</h2>
                     
             
            <div class="p-3 mt-6">
                <InputLabel for="subcontenedor_id" value="SubContenedor:"></InputLabel>
                <SelectInput id="contenedor_id" :options="subcontenedores"
                v-model="form.subcontenedor_id" type="text" class="mt-1 block w-3/4"
                placeholder="SubContenedor"></SelectInput>
                <InputError :message="form.errors.subcontenedor_id" class="mt-2"></InputError>
            </div>
            <div class="p-3 mt-6">
                <InputLabel for="cant_cajas" value=" Entre Cantidad de Cajas:"></InputLabel>
                <TextInput id="cant_cajas" 
                v-model="form.cant_cajas" type="text" class="mt-1 block w-3/4"
                placeholder="Cantidad de Cajas"></TextInput>
                <InputError :message="form.errors.cant_cajas" class="mt-2"></InputError>
            </div>
            <div class="p-3 mt-6">
                <PrimaryButton class="ml-3" :disable="form.processing" @click="save(id)">
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