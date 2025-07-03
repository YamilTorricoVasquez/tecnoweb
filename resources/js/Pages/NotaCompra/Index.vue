<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import Pagination from "@/Components/Pagination.vue"
import InputGroup from '@/Components/Forms/InputGroup.vue'
import Swal from 'sweetalert2'

import { Head, Link, usePage, useForm, router } from '@inertiajs/vue3'
import { ref, computed, watch } from 'vue'

defineProps({
    notacompras: {
        type: Object,
        required: true
    }
})

const page = usePage();
let search = ref(usePage().props.search), pageNumber = ref(1);

let notacomprasUrl = computed(() => {
    let url = new URL(route("notacompras.index"));
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
    () => notacomprasUrl.value,
    (updatedNotaComprasUrl) => {
        router.visit(updatedNotaComprasUrl, {
            preserveScroll: true,
            preserveState: true,
            replace: true,
        });
    }
);


const deleteForm = useForm({});

const deleteNotaCompra = (notacompraId) => {
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
            deleteForm.delete(route("notacompras.destroy", notacompraId), {
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

    <Head title="Nota compra List" />
    <AuthenticatedLayout>
        <DefaultLayout>
            <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="pb-4 px-5">
                    <div class="flex flex-col justify-between sm:flex-row mt-4">
                        <InputGroup v-model="search" type="text" autocomplete="off" placeholder="Buscar..." autofocus
                            customClasses="block" />
                        <!-- Table Header
                        <div class="mt-4 sm:ml-16 sm:flex-none">
                            <Link v-if="page.props.can.crear_notas_compras" :href="route('detallecompras.create')" class="
                  inline-flex items-center justify-center rounded
                bg-primary px-4 py-2 text-sm font-medium text-white shadow-sm 
                  hover:bg-indigo-700">
                            Registrar nota compra
                            </Link>
                        </div>
 -->
                    </div>
                </div>

                <!-- Table Header -->
                <div class="grid grid-cols-5 border-t border-stroke py-4.5 px-4 
               dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
                    <div class="col-span-1 flex items-center">
                        <p class="font-medium">fecha</p>
                    </div>

                    <div class="col-span-1 flex items-center">
                        <p class="font-medium">total</p>
                    </div>
                    <div class="col-span-1 flex items-center">
                        <p class="font-medium">Usuario</p>
                    </div>
                    <!-- <div class="col-span-1 flex items-center">
                        <p class="font-medium">Cliente</p>
                    </div>-->
                    <div class="col-span-1 flex items-center">
                        <p class="font-medium">Proovedor</p>
                    </div>
                    <div class="col-span-1 flex items-center">
                        <p class="font-medium">Metodo pago</p>
                    </div>
                    <div class="col-span-1 flex items-center">
                        <p class="font-medium">Acciones</p>
                    </div>
                </div>

                <!-- Table Rows -->
                <div v-for="notacompra in notacompras.data" :key="notacompra.id" class="grid grid-cols-5 border-t border-stroke 
                 py-4.5 px-4 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">

                    <div class="col-span-1 hidden items-center sm:flex">
                        <p class="text-sm font-medium text-black dark:text-white">{{ notacompra.fecha }}</p>
                    </div>
                    <div class="col-span-1 hidden items-center sm:flex">
                        <p class="text-sm font-medium text-black dark:text-white">{{ notacompra.total }}</p>
                    </div>
                    <div class="col-span-1 hidden items-center sm:flex">
                        <p class="text-sm font-medium text-black dark:text-white">{{ notacompra.user.name }}</p>
                    </div>
                    <!--  <div class="col-span-1 hidden items-center sm:flex">
                        <p class="text-sm font-medium text-black dark:text-white">{{ notacompra.cliente.nombre + " " +
                            notaventa.cliente.apellido }}
                        </p>
                    </div>-->
                    <div class="col-span-1 hidden items-center sm:flex">
                        <p class="text-sm font-medium text-black dark:text-white">{{ notacompra.proveedor.name }}
                        </p>
                    </div>
                    <div class="col-span-1 hidden items-center sm:flex">
                        <p class="text-sm font-medium text-black dark:text-white">{{ notacompra.paymentmethod.metodo }}
                        </p>
                    </div>
                    <!-- Table Rows -->
                    <div class="col-span-2 flex items-center">

                        <!-- Table Rows
                        <button v-if="page.props.can.eliminar_inventarios" @click="deleteNotaVenta(notaventa.id)"
                            class="ml-2 text-indigo-600 hover:text-indigo-900">
                            Delete
                        </button>-->

                    </div>

                </div>
            </div>

            <Pagination :data="notacompras" :updatedPageNumber="updatedPageNumber" />
        </DefaultLayout>
    </AuthenticatedLayout>
</template>