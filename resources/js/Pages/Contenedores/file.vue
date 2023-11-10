<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import SelectInput from '@/Components/SelectInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Swal from 'sweetalert2';
import { nextTick,ref } from 'vue';
import exportFromJSON from 'export-from-json';

const id = ref('');

const props = defineProps({
    contenedores: {type:Object},
    
    
})

const form = useForm({
    contenedores_id:''
})
const  exportar = () => {
    const alerta = Swal.mixin({
        buttonsStyling:true
    })
    alerta.fire({
        title:'Desea Exporta el Contenedor ?',
        icon: 'question', showCancelButton:true,
        confirmButtonText:'<i class = "fa-solid fa-check"></i> Confirmar',
        cancelButtonText: '<i class = "fa-solid fa-ban"></i> Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            form.get(route('exportar'),{
                onSuccess: () => {ok('Producto Cargado')}
            });
        }
    })
   } 
   const exp = () => {
    let timerInterval
Swal.fire({
  title: 'Cargando Contenedor',
  timer: 2000,
  timerProgressBar: true,
  didOpen: () => {
    Swal.showLoading()
    const b = Swal.getHtmlContainer().querySelector('b')
    timerInterval = setInterval(() => {
      b.textContent = Swal.getTimerLeft()
    }, 100)
  },
  willClose: () => {
    clearInterval(timerInterval)
  }
}).then((result) => {
  /* Read more about handling dismissals below */
  if (result.dismiss === Swal.DismissReason.timer) {
    form.get(route('exportar'))
  }
})
}
 


</script>

<template>
    <Head title="Cargar Contendedor" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Cargar Contenedor</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg place-items-center">
                    <form @submit.prevent="$event => exp()"
                    class="mt-6 space max-w-xl">
                        <div class="p-3 mt-6">
                            <InputLabel for="contenedores_id" value="Contenedores:"></InputLabel>
                            <SelectInput id="contenedores_id" :options="contenedores"
                            v-model="form.contenedores_id" type="text" class="mt-1 block w-3/4"
                            placeholder="contenedor"></SelectInput>
                            <InputError :message="form.errors.contenedores_id" class="mt-2"></InputError>
                        </div>

                        <PrimaryButton :disabled="form.processing">
                            <i class="fa-solid fa-save"></i> Cargar
                        </PrimaryButton>
                
                    </form>
                    
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>









