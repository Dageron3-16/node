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
    productos:{type:Object},
    gastosusd:{type:Object},
    gastoscup:{type:Object}
    
    
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
  title: 'Exportando Contenedor',
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
    const data = props;
    const fileName = 'Contenedor'
    const exportType =  exportFromJSON.types.json

    exportFromJSON({ data , fileName, exportType })
  }
})
}
 


</script>

<template>
    <Head title="Exportar Contenedor" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Exportar Contenedor</h2>
        </template>

        

                        <PrimaryButton @click="$event => exp()">
                            <i class="fa-solid fa-save"></i> Exportar
                        </PrimaryButton>
                
                  
                    
        
    </AuthenticatedLayout>
</template>
