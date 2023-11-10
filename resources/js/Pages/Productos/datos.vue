<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import SelectInput from '@/Components/SelectInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    contenedores: {type:Object},
    productos: {type:Object}
    
})
const form = useForm({
    contenedores_id:'',
    name:'',
    ValorUSD:'',
    propuesta:''
    
})
</script>

<template>
    <Head title="Calcular Venta" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Calcular Venta</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg place-items-center">
                    <form @submit.prevent="$event => form.post(route('ventas.store'))"
                    class="mt-6 space max-w-xl">
                    <InputLabel for="contenedores_id" value="Contenedores:"></InputLabel>
                    <SelectInput id="contenedores_id" :options="contenedores"
                         type="text" class="mt-1 block w-3/4" v-model="form.contenedores_id" autofocus required 
                        placeholder="Contenedores"></SelectInput>

                    <InputLabel for="name" value="Nombre del Producto:"></InputLabel>
                    <SelectInput id="name" :options="productos"
                         type="text" class="mt-1 block w-3/4"
                        placeholder="name" v-model="form.name" autofocus required ></SelectInput> 

                    <InputLabel form="propuesta" value="Venta Propuesta:"></InputLabel>
                    <TextInput id="propuesta" v-model="form.propuesta"   autofocus required 
                        type="text"
                        class="mt-1 block w-3/4"></TextInput>
                    <InputError :message="form.errors.propuesta" class="mt-2"></InputError>                       
                    <PrimaryButton :disabled="form.processing">
                            <i class="fa-solid fa-save"></i> Calcular
                    </PrimaryButton>
                
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
