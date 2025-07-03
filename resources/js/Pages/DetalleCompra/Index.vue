<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import Pagination from "@/Components/Pagination.vue"
import InputGroup from '@/Components/Forms/InputGroup.vue'
import Swal from 'sweetalert2'

import { Head, Link, usePage, useForm, router } from '@inertiajs/vue3'
import { ref, computed, watch } from 'vue'

defineProps({
    detallecompras: {
        type: Object,
        required: true
    }
})

const page = usePage();
let search = ref(usePage().props.search), pageNumber = ref(1);

let detallecomprasUrl = computed(() => {
    let url = new URL(route("detallecompras.index"));
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
    () => detallecomprasUrl.value,
    (updatedDetalleComprasUrl) => {
        router.visit(updatedDetalleComprasUrl, {
            preserveScroll: true,
            preserveState: true,
            replace: true,
        });
    }
);


const deleteForm = useForm({});

const deleteDetalleCompra = (detallecompraId) => {
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
            deleteForm.delete(route("detallecompras.destroy", detallecompraId), {
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

    <Head title="Detalle venta List" />
    <AuthenticatedLayout>
        <DefaultLayout>
            <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="pb-4 px-5">
                    <div class="flex flex-col justify-between sm:flex-row mt-4">
                        <InputGroup v-model="search" type="text" autocomplete="off" placeholder="Buscar..." autofocus
                            customClasses="block" />
                        <!-- Table Header 
                        <div class="mt-4 sm:ml-16 sm:flex-none">
                            <Link v-if="page.props.can.crear_detalle_compra" :href="route('detallecompras.create')"
                                class="
                  inline-flex items-center justify-center rounded
                bg-primary px-4 py-2 text-sm font-medium text-white shadow-sm 
                  hover:bg-indigo-700">
                            Registra detalle compra
                            </Link>
                        </div>
-->
                    </div>
                </div>

                <!-- Table Header -->
                <div class="grid grid-cols-5 border-t border-stroke py-4.5 px-4 
               dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
                    <div class="col-span-1 flex items-center">
                        <p class="font-medium">cantidad</p>
                    </div>

                    <div class="col-span-1 flex items-center">
                        <p class="font-medium">Precio de compra</p>
                    </div>
                    <div class="col-span-1 flex items-center">
                        <p class="font-medium">total</p>
                    </div>
                    <div class="col-span-1 flex items-center">
                        <p class="font-medium">producto</p>
                    </div>


                    <div class="col-span-1 flex items-center">
                        <p class="font-medium">Acciones</p>
                    </div>
                </div>

                <!-- Table Rows -->
                <div v-for="detallecompra in detallecompras.data" :key="detallecompra.id" class="grid grid-cols-5 border-t border-stroke 
                 py-4.5 px-4 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">

                    <div class="col-span-1 hidden items-center sm:flex">
                        <p class="text-sm font-medium text-black dark:text-white">{{ detallecompra.cantidad }}</p>
                    </div>
                    <div class="col-span-1 hidden items-center sm:flex">
                        <p class="text-sm font-medium text-black dark:text-white">{{ detallecompra.precio_compra }}</p>
                    </div>
                    <div class="col-span-1 hidden items-center sm:flex">
                        <p class="text-sm font-medium text-black dark:text-white">{{ detallecompra.total }}</p>
                    </div>
                    <div class="col-span-1 hidden items-center sm:flex">
                        <p class="text-sm font-medium text-black dark:text-white">{{ detallecompra.producto.name }}</p>
                    </div>


                    <!-- Table Rows 
                    <div class="col-span-2 flex items-center">
                        <Link v-if="page.props.can.editar_inventarios" :href="route('notaventas.edit', notaventa.id)"
                            class="text-indigo-600 hover:text-indigo-900">
                        Edit
                        </Link>
                        <button v-if="page.props.can.eliminar_inventarios" @click="deleteDevolucion(notaventa.id)"
                            class="ml-2 text-indigo-600 hover:text-indigo-900">
                            Delete
                        </button>

                    </div>-->

                </div>
            </div>

            <Pagination :data="detallecompras" :updatedPageNumber="updatedPageNumber" />
        </DefaultLayout>
    </AuthenticatedLayout>
</template>