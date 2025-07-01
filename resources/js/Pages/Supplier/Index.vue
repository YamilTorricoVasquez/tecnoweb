<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import Pagination from "@/Components/Pagination.vue"
import InputGroup from '@/Components/Forms/InputGroup.vue'
import Swal from 'sweetalert2'

import { Head, Link, usePage, useForm, router } from '@inertiajs/vue3'
import { ref, computed, watch } from 'vue'

defineProps({
    suppliers: {
        type: Object,
        required: true
    }
});

const page = usePage();
let search = ref(usePage().props.search);
let pageNumber = ref(1);

let suppliersUrl = computed(() => {
    let url = new URL(route("suppliers.index"));
    url.searchParams.append("page", pageNumber.value);

    if (search.value) {
        url.searchParams.append("search", search.value);
    }

    return url.toString();
});

const updatedPageNumber = (link) => {
    const params = new URL(link.url).searchParams;
    pageNumber.value = params.get("page") || 1;
};

watch(
    () => suppliersUrl.value,
    (updatedSuppliersUrl) => {
        router.visit(updatedSuppliersUrl, {
            preserveScroll: true,
            preserveState: true,
            replace: true,
        });
    }
);

const deleteForm = useForm({});

const deleteSupplier = (supplierId) => {
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
            deleteForm.delete(route("suppliers.destroy", supplierId), {
                preserveScroll: true,
            });
            Swal.fire({
                title: "Deleted!",
                text: "Your data has been deleted.",
                icon: "success"
            });
        }
    });
};
</script>

<template>

    <Head title="Lista de proveedores" />
    <AuthenticatedLayout>
        <DefaultLayout>
            <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">

                <div class="pb-4 px-5">
                    <div class="flex flex-col justify-between sm:flex-row mt-4">
                        <InputGroup v-model="search" type="text" autocomplete="off" placeholder="Buscar..." autofocus
                            customClasses="block" />
                        <!-- Table Header 
                        <div class="mt-4 sm:ml-16 sm:flex-none">
                            <Link v-if="page.props.can.supplier_create" :href="route('suppliers.create')"
                                class="inline-flex items-center justify-center rounded bg-primary px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">
                            Agregar proveedor
                            </Link>
                        </div>-->
                    </div>
                </div>

                <!-- Table Header -->
                <div
                    class="grid grid-cols-3 border-t border-stroke py-4.5 px-4 dark:border-strokedark sm:grid-cols-4 md:px-6 2xl:px-7.5">
                    <div class="col-span-1 flex items-center">
                        <p class="font-medium">Nombre del proveedor</p>
                    </div>
                    <div class="col-span-1 flex items-center">
                        <p class="font-medium">Nombre de la empresa</p>
                    </div>
                    <div class="col-span-1 flex items-center">
                        <p class="font-medium">Celular</p>
                    </div>
                    <div class="col-span-1 flex items-center">
                        <p class="font-medium">Acciones</p>
                    </div>
                </div>

                <!-- Table Rows -->
                <div v-for="supplier in suppliers.data" :key="supplier.id"
                    class="grid grid-cols-3 border-t border-stroke py-4.5 px-4 dark:border-strokedark sm:grid-cols-4 md:px-6 2xl:px-7.5">
                    <div class="col-span-1 flex items-center">
                        <p class="text-sm font-medium text-black dark:text-white">{{ supplier.name }}</p>
                    </div>
                    <div class="col-span-1 flex items-center">
                        <p class="text-sm font-medium text-black dark:text-white">{{ supplier.nombre_empresa }}</p>
                    </div>
                    <div class="col-span-1 flex items-center">
                        <p class="text-sm font-medium text-black dark:text-white">{{ supplier.phone }}</p>
                    </div>
                    <div class="col-span-1 flex items-center">
                        <Link v-if="page.props.can.supplier_edit" :href="route('suppliers.edit', supplier.id)"
                            class="text-indigo-600 hover:text-indigo-900">
                        Edit
                        </Link>
                        <button v-if="page.props.can.supplier_delete" @click="deleteSupplier(supplier.id)"
                            class="ml-2 text-indigo-600 hover:text-indigo-900">
                            Delete
                        </button>
                    </div>
                </div>
            </div>

            <Pagination :data="suppliers" :updatedPageNumber="updatedPageNumber" />
        </DefaultLayout>
    </AuthenticatedLayout>
</template>
