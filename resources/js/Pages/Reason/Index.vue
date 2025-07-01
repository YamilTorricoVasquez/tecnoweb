<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import Pagination from "@/Components/Pagination.vue"
import InputGroup from '@/Components/Forms/InputGroup.vue'
import Swal from 'sweetalert2'

import { Head, Link, usePage, useForm, router } from '@inertiajs/vue3'
import { ref, computed, watch } from 'vue'

defineProps({
    reasons: {
        type: Object,
        required: true
    }
})

const page = usePage();
let search = ref(usePage().props.search), pageNumber = ref(1);

let reasonsUrl = computed(() => {
    let url = new URL(route("reasons.index"));
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
    () => reasonsUrl.value,
    (updatedreasonsUrl) => {
        router.visit(updatedreasonsUrl, {
            preserveScroll: true,
            preserveState: true,
            replace: true,
        });
    }
);

const deleteForm = useForm({});

const deleteReason = (reasonId) => {
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
            deleteForm.delete(route("reasons.destroy", reasonId), {
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

    <Head title="Reason List" />
    <AuthenticatedLayout>
        <DefaultLayout>
            <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="pb-4 px-5">
                    <div class="flex flex-col justify-between sm:flex-row mt-4">
                        <InputGroup v-model="search" type="text" autocomplete="off" placeholder="Buscar..." autofocus
                            customClasses="block" />

                        <div class="mt-4 sm:ml-16 sm:flex-none">
                            <Link v-if="page.props.can.inventory_create" :href="route('reasons.create')" class="
                  inline-flex items-center justify-center rounded
                bg-primary px-4 py-2 text-sm font-medium text-white shadow-sm 
                  hover:bg-indigo-700">
                            Agregar razon
                            </Link>
                        </div>

                    </div>
                </div>

                <!-- Table Header -->
                <div class="grid grid-cols-3 border-t border-stroke py-4.5 px-4 
               dark:border-strokedark sm:grid-cols-4 md:px-6 2xl:px-7.5">
                    <div class="col-span-2 flex items-center">
                        <p class="font-medium">Descripcion</p>
                    </div>
                    <div class="col-span-1 flex items-center">
                        <p class="font-medium">Acciones</p>
                    </div>
                </div>

                <!-- Table Rows -->
                <div v-for="reason in reasons.data" :key="reason.id" class="grid grid-cols-3 border-t border-stroke 
                 py-4.5 px-4 dark:border-strokedark sm:grid-cols-4 md:px-6 2xl:px-7.5">
                    <div class="col-span-2 flex items-center">
                        <p class="text-sm font-medium text-black dark:text-white">{{ reason.descripcion }}</p>
                    </div>
                    <!--  -->
                    <div class="col-span-1 flex items-center">
                        <Link v-if="page.props.can.reason_edit" :href="route('reasons.edit', reason.id)"
                            class="text-indigo-600 hover:text-indigo-900">
                        Edit
                        </Link>
                        <button v-if="page.props.can.reason_delete" @click="deleteReason(reason.id)"
                            class="ml-2 text-indigo-600 hover:text-indigo-900">
                            Delete
                        </button>

                    </div>
                </div>
            </div>

            <Pagination :data="reasons" :updatedPageNumber="updatedPageNumber" />
        </DefaultLayout>
    </AuthenticatedLayout>
</template>