<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
const props = defineProps({
    contenedores:{type:Object}, 
    productos:{type:Object}
    
})
const form = useForm({
    costo_contenedor:props.contenedores.costo_contenedor,
    flete:props.contenedores.flete,
    id:props.id
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
                        <InputLabel form="costo_contenedor" value="Costo contenedor"></InputLabel>
                        <TextInput id="costo_contenedor" v-model="form.costo_contenedor" autofocus required 
                        type="text"
                        class="mt-1 block w-full"></TextInput>
                        <InputError :message="form.errors.costo_contenedor" class="mt-2"></InputError>
                        
                        <InputLabel form="flete" value="flete"></InputLabel>
                        <TextInput id="flete" v-model="form.flete" autofocus required 
                        type="text"
                        class="mt-1 block w-full"></TextInput>
                        <InputError :message="form.errors.flete" class="mt-2"></InputError>
                        <PrimaryButton :disabled="form.processing">
                            <i class="fa-solid fa-save"></i> Salvar
                        </PrimaryButton>
                    </form>
                    
                </div>
             
            </div>
        </div>
    </AuthenticatedLayout>
</template>
