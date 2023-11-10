<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    name:'',
    provedor:'',
    valorusd_mercado:'',
    costo_contenedor:'',
    fecha:''
})



</script>

<template>
    <Head title="Create SubContenedor" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear SubContenedor</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg place-items-center">
                    <form @submit.prevent="$event => form.post(route('subcontenedor.store'))"
                    class="mt-6 space max-w-xl">
                        <InputLabel form="name" value="Nombre"></InputLabel>
                        <TextInput id="name" v-model="form.name" autofocus required 
                        type="text"
                        class="mt-1 block w-full"></TextInput>
                        <InputError :message="form.errors.name" class="mt-2"></InputError>

                        <InputLabel form="provedor" value="Provedor"></InputLabel>
                        <TextInput id="provedor" v-model="form.provedor" autofocus required 
                        type="text"
                        class="mt-1 block w-full"></TextInput>
                        <InputError :message="form.errors.provedor" class="mt-2"></InputError>
                        
                                               
                        <InputLabel form="valorusd_mercado" value="Valor USD mercado"></InputLabel>
                        <TextInput id="valorusd_mercado" v-model="form.valorusd_mercado" autofocus required 
                        type="text"
                        class="mt-1 block w-full"></TextInput>
                        <InputError :message="form.errors.valorusd_mercado" class="mt-2"></InputError>  
                        
                                               
                        <InputLabel form="fecha" value="fecha"></InputLabel>
                        <TextInput id="fecha" v-model="form.fecha" autofocus required 
                        type="date"
                        class="mt-1 block w-full"></TextInput>
                        <InputError :message="form.errors.fecha" class="mt-2"></InputError>  

                        <PrimaryButton :disabled="form.processing">
                            <i class="fa-solid fa-save"></i> Añadir SubProducto
                        </PrimaryButton>
                
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
