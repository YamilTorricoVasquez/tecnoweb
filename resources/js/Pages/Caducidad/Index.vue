<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import Pagination from "@/Components/Pagination.vue"
import InputGroup from '@/Components/Forms/InputGroup.vue'
import Swal from 'sweetalert2'

import { Head, Link, usePage, useForm, router } from '@inertiajs/vue3'
import { ref, computed, watch } from 'vue'

defineProps({
    caducidades: {
        type: Object,
        required: true
    }
})

const page = usePage();
let search = ref(usePage().props.search), pageNumber = ref(1);

let caducidadesUrl = computed(() => {
    let url = new URL(route("caducidades.index"));
    url.searchParams.append("page", pageNumber.value);

    if (search.value) {
        url.searchParams.append("search", search.value);
    }

    return url;
});

const updatedPageNumber = (link) => {
    pageNumber.value = link.url.split("=")[1];
};

watch(
    () => caducidadesUrl.value,
    (updatedCaducidadesUrl) => {
        router.visit(updatedCaducidadesUrl, {
            preserveScroll: true,
            preserveState: true,
            replace: true,
        });
    }
);


const deleteForm = useForm({});

const deleteCaducidad = (caducidadId) => {
    Swal.fire({
        title: "Estas seguro",
        text: "¡No podrás revertir esto!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, eliminalo!"
    }).then((result) => {
        if (result.isConfirmed) {
            deleteForm.delete(route("caducidades.destroy", caducidadId), {
                preserveScroll: true,
            });
            Swal.fire({
                title: "Deleted!",
                text: "Your data has been deleted.",
                icon: "success"
            });
        }
    });

}

</script>

<template>

    <Head title="Lista de caducidad" />
    <AuthenticatedLayout>
        <DefaultLayout>
            
            <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="pb-4 px-5">
                    <div class="flex flex-col justify-between sm:flex-row mt-4">
                        <InputGroup v-model="search" type="text" autocomplete="off" placeholder="Buscar..." autofocus
                            customClasses="block" />
                    </div>
                </div>
                <!-- Table Header -->
                <div class="grid grid-cols-5 border-t border-stroke py-4.5 px-4 
               dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
                    <div class="col-span-1 flex items-center">
                        <p class="font-medium">Fecha caducidad</p>
                    </div>

                    <div class="col-span-1 flex items-center">
                        <p class="font-medium">Cantidad</p>
                    </div>

                    <div class="col-span-1 flex items-center">
                        <p class="font-medium">producto</p>
                    </div>


                    <div class="col-span-1 flex items-center">
                        <p class="font-medium">Acciones</p>
                    </div>
                </div>

                <!-- Table Rows -->
                <div v-for="caducidad in caducidades.data" :key="caducidad.id" class="grid grid-cols-5 border-t border-stroke 
                 py-4.5 px-4 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">

                    <div class="col-span-1 hidden items-center sm:flex">
                        <p class="text-sm font-medium text-black dark:text-white">{{ caducidad.fecha_caducidad }}</p>
                    </div>
                    <div class="col-span-1 hidden items-center sm:flex">
                        <p class="text-sm font-medium text-black dark:text-white">{{ caducidad.cantidad }}</p>
                    </div>

                    <div class="col-span-1 hidden items-center sm:flex">
                        <p class="text-sm font-medium text-black dark:text-white">{{ caducidad.producto.name }}</p>
                    </div>

                </div>
            </div>

            <Pagination :data="caducidades" :updatedPageNumber="updatedPageNumber" />
        </DefaultLayout>
    </AuthenticatedLayout>
</template>