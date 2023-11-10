<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import SelectInput from '@/Components/SelectInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Swal from 'sweetalert2';



/*const props = defineProps({
    
})*/

const form = useForm({
    file:null,
})

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
    form.post(route('import'),{
        onSuccess: () => {Swal.fire({title:'Importado con Exito',icon:'success'});}
    })
  }
})
}
</script>

<template>
    <Head title="ImportarContenedor" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Importar Contenedor</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg place-items-center">
                    <form @submit.prevent="$event => exp()"
                    class="mt-6 space max-w-xl" enctype="multipart/form-data">
                    
                        <input class="form-control block mt-1 w-full rounded-md form-input focus:border-indigo-600" type="file"  @input="form.file = $event.target.files[0]">
                    

                        <PrimaryButton :disabled="form.processing">
                            <i class="fa-solid fa-save"></i> Importar
                        </PrimaryButton>
                
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>









