<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
const props = defineProps({
    contenedores:{type:Object},
    
})
const form = useForm({
    costo_contenedor:props.contenedores.costo_contenedor,
    flete:props.contenedores.flete,
    
})
const calculatePorciento = (id) => {
    form.patch(route('costo_total', id))
}
</script>

<template>
    <Head title="CreateContenedor" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Contenedor</h2>
        </template>

       <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg place-items-center">
                    <form @submit.prevent="$event => form.put(route('contenedor.update', contenedores ))"
                    class="mt-6 space max-w-xl">
                        <InputLabel form="name" value="Numero de Factura"></InputLabel>
                        <TextInput id="name" v-model="form.name" autofocus required 
                        type="text"
                        class="mt-1 block w-full"></TextInput>
                        <InputError :message="form.errors.name" class="mt-2"></InputError>

                        <InputLabel form="provedor" value="Provedor"></InputLabel>
                        <TextInput id="provedor" v-model="form.provedor" autofocus required 
                        type="text"
                        class="mt-1 block w-full"></TextInput>
                        <InputError :message="form.errors.provedor" class="mt-2"></InputError>
                        
                        <InputLabel form="costo_contenedor" value="Costo del Contenedor"></InputLabel>
                        <TextInput id="costo_contenedor" v-model="form.costo_contenedor" autofocus required 
                        type="text"
                        class="mt-1 block w-full"></TextInput>
                        <InputError :message="form.errors.tipo_gasto" class="mt-2"></InputError>
                        
                        <InputLabel form="valorusd_mercado" value="valorusd_mercado"></InputLabel>
                        <TextInput id="valorusd_mercado" v-model="form.valorusd_mercado" autofocus required 
                        type="text"
                        class="mt-1 block w-full"></TextInput>
                        <InputError :message="form.errors.valorusd_mercado" class="mt-2"></InputError>  
                        
                        <InputLabel form="flete" value="Flete"></InputLabel>
                        <TextInput id="flete" v-model="form.flete" autofocus required 
                        type="text"
                        class="mt-1 block w-full"></TextInput>
                        <InputError :message="form.errors.flete" class="mt-2"></InputError>  
                        
                        <InputLabel form="fecha_llegada" value="fecha_llegada"></InputLabel>
                        <TextInput id="fecha_llegada" v-model="form.fecha" autofocus required 
                        type="date"
                        class="mt-1 block w-full"></TextInput>
                        <InputError :message="form.errors.fecha_llegada" class="mt-2"></InputError>  

                        <InputLabel form="fecha_salida" value="fecha_salida"></InputLabel>
                        <TextInput id="fecha_salida" v-model="form.fecha_salida" autofocus required 
                        type="date"
                        class="mt-1 block w-full"></TextInput>
                        <InputError :message="form.errors.fecha_salida" class="mt-2"></InputError>

                        <InputLabel form="tiempo_venta" value="tiempo_venta"></InputLabel>
                        <TextInput id="tiempo_venta" v-model="form.tiempo_venta" autofocus required 
                        type="date"
                        class="mt-1 block w-full"></TextInput>
                        <InputError :message="form.errors.tiempo_venta" class="mt-2"></InputError>

                        <PrimaryButton :disabled="form.processing">
                            <i class="fa-solid fa-save"></i> Salvar
                        </PrimaryButton>
                
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
