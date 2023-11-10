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
    gastosusd: {type:Object},
    contenedores: {type:Object}
})
const form = useForm({
    nombre_gastousd:'', 
    valor_gastousd:'',
    contenedores_id:'',
    buscador:''
    
 
});

const formPage = useForm({});

const onPageClick = (event)=>{
    formPage.get(route('gastosusd.index', {page:event}));
}

const openModal = (op,nombre_gastousd,valor_gastousd, contenedores_id, gastousd) => {
modal.value = true;
nextTick( () => nameInput.value.focus());
operation.value = op;
id.value = gastousd;
if (op == 1) {
    tittle.value = 'Crear gasto';
}
else{
    tittle.value = 'Editar gasto';
    form.nombre_gastousd=nombre_gastousd;
    form.valor_gastousd=valor_gastousd;
    form.contenedores_id=contenedores_id;
}
}
const closeModal = () => {
    modal.value = false;
    form.reset();
}
const buscarProducto = () =>{
    form.get(route('searchgastousd'));
}
const save = () => {
    if (operation.value==1) {
        form.post(route('gastosusd.store'),{
            onSuccess: () => {ok('Gasto Añadido al Contenedor')}
        });
    }
    else{
        form.put(route('gastosusd.update', id.value),{
            onSuccess: () => {ok('Gasto Actualizado')}
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
        title:'Desea Eliminar el Gasto  ?',
        icon: 'question', showCancelButton:true,
        confirmButtonText:'<i class = "fa-solid fa-check"></i> Eliminar',
        cancelButtonText: '<i class = "fa-solid fa-ban"></i> Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route('gastosusd.destroy', id),{
                onSuccess: () => {ok('Gasto Eliminado')}
            });
        }
    })
}
</script>

<template>
    <Head title="Gastos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gastos</h2>
            <div>
                    <input type="text" v-model="form.buscador" class="form-control px-4 py-2 bg-white-800 text-black border rounded-md font-semibold text-xl text-gray-800 leading-tight float-right text-xs"/>
                    <button @click="buscarProducto" type="button" class = "px-4 py-2 bg-gray-800 text-white border rounded-md font-semibold text-xl text-gray-800 leading-tight float-right text-xs">Buscar</button>
            </div>
        </template>

        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center">
                <div class="mt-3 mb-3 flex">
                    <PrimaryButton @click="$event => openModal(1)">
                        <i class="fa-solid fa-plus-cicle"></i>Añadir
                    </PrimaryButton>
                </div>
            </div>
            <div class="bg-white grid v-screen place-items-center overflow-x-auto">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-4">#</th>
                            <th class="px-4 py-4">Factura</th>
                            <th class="px-4 py-4">Nombre del Gasto</th>
                            <th class="px-4 py-4">Valor</th>
                            
                            <th class="px-4 py-4"></th>
                            <th class="px-4 py-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="gas, i in gastosusd.data" :key="gas.id">
                           <td class="border border-gray-400 px-2 py-2">{{(i+1)}}</td> 
                           <td class="border border-gray-400 px-2 py-2">{{gas.factura_gastosusd}}</td>
                           <td class="border border-gray-400 px-2 py-2">{{gas.nombre_gastousd}}</td>
                           <td class="border border-gray-400 px-2 py-2">{{gas.valor_gastousd}}</td>
                           <td class="border border-gray-400 px-2 py-2">
                                <WarningButton
                                @click="$event => openModal(2, gas.nombre_gastousd, gas.valor_gastousd, gas.contenedores_id, gas.id)">
                                <i class="fa-solid fa-edit"></i>
                            </WarningButton>
                            
                           </td>
                           
                           <td class="border border-gray-400 px-2 py-2">
                            <DangerButton @click="$event => deleteProducto(gas.id)">
                                <i class="fa-solid fa-trash"></i>
                            </DangerButton>
                           </td>
                        </tr>
                    </tbody>
                </table>
            
            </div>  
            <div class="bg-white grid v-screen place-items-center">
                <VueTailwindPagination 
                     :current= "gastosusd.currentPage" 
                     :total="gastosusd.total"
                     :per-page = "gastosusd.perPage"
                     @page-changed="$event => onPageClick($event)"
                ></VueTailwindPagination>
        </div>   
        </div>
        <Modal :show="modal" @close="closeModal">
            <h2 class="p3 text-lg font.medium text-hray-900">{{ tittle }}</h2>
            <div class="p-3 mt-6">
                <InputLabel for="nombre_gastousd" value="Nombre:"></InputLabel>
                <TextInput id="nombre_gastousd" ref="nameInput"
                v-model="form.nombre_gastousd" type="text" class="mt-1 block w-3/4"
                placeholder="nombre del gasto"></TextInput>
                <InputError :message="form.errors.nombre_gastousd" class="mt-2"></InputError>
            </div>
            <div class="p-3 mt-6">
                <InputLabel for="valor_gastousd" value="Valor:"></InputLabel>
                <TextInput id="valor_gastousd" 
                v-model="form.valor_gastousd" type="text" class="mt-1 block w-3/4"
                placeholder="valor"></TextInput>
                <InputError :message="form.errors.valor_gastousd" class="mt-2"></InputError>
            </div>
            
            <div class="p-3 mt-6">
                <InputLabel for="contenedores_id" value="Contenedores:"></InputLabel>
                <SelectInput id="contenedores_id" :options="contenedores"
                v-model="form.contenedores_id" type="text" class="mt-1 block w-3/4"
                ></SelectInput>
                <InputError :message="form.errors.contenedores_id" class="mt-2"></InputError>
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