<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import Pagination from "@/Components/Pagination.vue"
import InputGroup from '@/Components/Forms/InputGroup.vue'
import Swal from 'sweetalert2'

import { Head, Link, usePage, useForm, router } from '@inertiajs/vue3'
import { ref, computed, watch } from 'vue'

defineProps({
    clientes: {
        type: Object,
        required: true
    }
})

const page = usePage();
let search = ref(usePage().props.search), pageNumber = ref(1);

let clientesUrl = computed(() => {
    let url = new URL(route("clientes.index"));
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
    () => clientesUrl.value,
    (updatedclientesUrl) => {
        router.visit(updatedclientesUrl, {
            preserveScroll: true,
            preserveState: true,
            replace: true,
        });
    }
);

const deleteForm = useForm({});

const deleteCliente = (clienteId) => {
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
            deleteForm.delete(route("clientes.destroy", clienteId), {
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
// Método para capitalizar
const capitalizeWords = (input) => {
    return input.replace(/\b\w/g, (char) => char.toUpperCase());
};
</script>

<template>

    <Head title="Lista Clientes" />
    <AuthenticatedLayout>
        <DefaultLayout>
            <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="pb-4 px-5">
                    <div class="flex flex-col justify-between sm:flex-row mt-4">
                        <InputGroup v-model="search" type="text" autocomplete="off" placeholder="Buscar..." autofocus
                            customClasses="block" />
                        <!-- Table Header 
                        <div class="mt-4 sm:ml-16 sm:flex-none">
                            <Link v-if="page.props.can.crear_inventarios" :href="route('clientes.create')" class="
                  inline-flex items-center justify-center rounded
                bg-primary px-4 py-2 text-sm font-medium text-white shadow-sm 
                  hover:bg-indigo-700">
                            Registrar clientes
                            </Link>
                        </div>
-->
                    </div>
                </div>

                <!-- Table Header -->
                <div class="grid grid-cols-3 border-t border-stroke py-4.5 px-4 
               dark:border-strokedark sm:grid-cols-4 md:px-6 2xl:px-7.5">
                    <div class="col-span-1 flex items-center">
                        <p class="font-medium">Nombre</p>
                    </div>
                    <div class="col-span-1 flex items-center">
                        <p class="font-medium">Apellido</p>
                    </div>
                    <div class="col-span-1 flex items-center">
                        <p class="font-medium">Acciones</p>
                    </div>
                </div>

                <!-- Table Rows -->
                <div v-for="cliente in clientes.data" :key="cliente.id" class="grid grid-cols-3 border-t border-stroke 
                 py-4.5 px-4 dark:border-strokedark sm:grid-cols-4 md:px-6 2xl:px-7.5">
                    <div class="col-span-1 flex items-center">
                        <p class="text-sm font-medium text-black dark:text-white">{{ cliente.nombre }}</p>
                    </div>
                    <div class="col-span-1 flex items-center">
                        <p class="text-sm font-medium text-black dark:text-white">{{ cliente.apellido }}</p>
                    </div>
                    <!--  -->
                    <div class="col-span-1 flex items-center">
                        <Link v-if="page.props.can.editar_inventarios" :href="route('clientes.edit', cliente.id)"
                            class="text-indigo-600 hover:text-indigo-900">
                        Editar
                        </Link>
                        <button v-if="page.props.can.eliminar_inventarios" @click="deleteCliente(cliente.id)"
                            class="ml-2 text-indigo-600 hover:text-indigo-900">
                            Eliminar
                        </button>

                    </div>
                </div>
            </div>

            <Pagination :data="clientes" :updatedPageNumber="updatedPageNumber" />
        </DefaultLayout>
    </AuthenticatedLayout>
</template>