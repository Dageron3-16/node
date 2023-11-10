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



const nameInput = ref(null); 
const modal = ref(false);  
const tittle = ref(''); 
const operation = ref(1);
const id = ref('');


const props = defineProps({
    productos: {type:Object},
    contenedores: {type:Object}
})
const form = useForm({
    name:'', 
    cod_producto:'', 
    cant_producto:'',
    cant_cajas:'', 
    cant_parle:'', 
    precio_producto:'', 
    precio_total:'',
    precio_total:'',
    porciento_total:'',
    costo_flete:'',
    contenedores_id:''
});


const openModal = (op, contenedores_id,name,cant_producto,cant_cajas,precio_caja, producto) => {
modal.value = true;
nextTick( () => nameInput.value.focus());
operation.value = op;
id.value = producto;
if (op == 1) {
    tittle.value = 'Crear Producto';
}
else{
    tittle.value = 'Editar Producto';
    form.name=name;
    form.cant_producto=cant_producto;
    form.cant_cajas=cant_cajas;
    form.precio_caja= precio_caja;
    form.contenedores_id=contenedores_id;
}
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
        form.put(route('productos.update', id.value),{
            onSuccess: () => {ok('Producto Actualizado')}
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
            form.delete(route('productos.destroy', id),{
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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight" >Producto</h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center">
                <div class="mt-3 mb-3 flex">
                    <PrimaryButton @click="$event => openModal(1)">
                        <i class="fa-solid fa-plus-cicle"></i>Salvar
                    </PrimaryButton>
                </div>
            </div>
            <div class="bg-white grid v-screen place-items-center overflow-x-auto">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <th class="px-4 py-4">#</th>
                            <th class="px-4 py-4">Contenedor</th>
                            <th class="px-4 py-4">Nombre</th>
                            <th class="px-4 py-4">Cantidad</th>
                            <th class="px-4 py-4">Cantidad de Cajas</th>
                            <th class="px-4 py-4">Precio por Caja</th>
                            <th class="px-4 py-4">Precio Total</th>
                            <th class="px-4 py-4">Precio Unitario USD</th>
                            <th class="px-4 py-4">Porciento del Total</th>
                            <th class="px-4 py-4">Flete del Producto</th>
                            <th class="px-4 py-4">Total con Gastos</th>
                            <th class="px-4 py-4">Unitario con Gastos</th>
                            <th class="px-4 py-4"></th>
                            <th class="px-4 py-4"></th>
                            <th class="px-4 py-4"></th>
                    </thead>
                    <tbody>
                        <tr v-for="pro, i in productos" :key="pro.id">
                            <td class="border border-gray-400 px-2 py-2">{{(i+1)}}</td> 
                           <td class="border border-gray-400 px-2 py-2">{{pro.contenedores_id}}</td>
                           <td class="border border-gray-400 px-2 py-2">{{pro.name}}</td>
                           <td class="border border-gray-400 px-2 py-2">{{pro.cant_producto}}</td>
                           <td class="border border-gray-400 px-2 py-2">{{pro.cant_cajas}}</td>
                           <td class="border border-gray-400 px-2 py-2">{{pro.precio_caja}}</td>
                           <td class="border border-gray-400 px-2 py-2">{{pro.precio_total}}</td>
                           <td class="border border-gray-400 px-2 py-2">{{pro.precio_unitariousd}}</td>
                           <td class="border border-gray-400 px-2 py-2">{{pro.porciento_total}}</td>
                           <td class="border border-gray-400 px-2 py-2">{{pro.costo_flete}}</td>
                           <td class="border border-gray-400 px-2 py-2">{{pro.producto_gastousd}}</td>
                           <td class="border border-gray-400 px-2 py-2">{{pro.unitario_gastousd}}</td>
                           <td class="border border-gray-400 px-2 py-2">
                                <WarningButton
                                    @click="$event => openModal(2,pro.contenedores_id, pro.name, pro.cant_producto, pro.cant_cajas, pro.cant_parle, pro.precio_producto, pro.id)">
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
                <InputLabel for="name" value="Nombre:"></InputLabel>
                <TextInput id="name" ref="nameInput"
                v-model="form.name" type="text" class="mt-1 block w-3/4"
                placeholder="name del producto"></TextInput>
                <InputError :message="form.errors.name" class="mt-2"></InputError>
            </div>
            <div class="p-3 mt-6">
                <InputLabel for="cant_producto" value="Cantidad de Producto:"></InputLabel>
                <TextInput id="cant_producto" 
                v-model="form.cant_producto" type="text" class="mt-1 block w-3/4"
                placeholder="Cantidad de Producto"></TextInput>
                <InputError :message="form.errors.cant_producto" class="mt-2"></InputError>
            </div>
            <div class="p-3 mt-6">
                <InputLabel for="cant_cajas" value="Cantidad de Cajas:"></InputLabel>
                <TextInput id="cant_cajas" 
                v-model="form.cant_cajas" type="text" class="mt-1 block w-3/4"
                placeholder="Cantidad de Cajas"></TextInput>
                <InputError :message="form.errors.cant_cajas" class="mt-2"></InputError>
            </div>
            <div class="p-3 mt-6">
                <InputLabel for="precio_caja" value="Precio de la Caja:"></InputLabel>
                <TextInput id="precio_caja" 
                v-model="form.precio_caja" type="text" class="mt-1 block w-3/4"
                placeholder="Precio de la Caja"></TextInput>
                <InputError :message="form.errors.precio_caja" class="mt-2"></InputError>
            </div>
           
             
            <div class="p-3 mt-6">
                <InputLabel for="contenedores_id" value="Contenedores:"></InputLabel>
                <SelectInput id="contenedores_id" :options="contenedores"
                v-model="form.contenedores_id" type="text" class="mt-1 block w-3/4"
                placeholder="nombre del producto"></SelectInput>
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