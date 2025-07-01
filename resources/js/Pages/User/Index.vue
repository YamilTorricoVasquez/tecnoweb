<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import Pagination from "@/Components/Pagination.vue"
import InputGroup from '@/Components/Forms/InputGroup.vue'
import Swal from 'sweetalert2'

import { Head, Link, usePage, useForm, router } from '@inertiajs/vue3'
import { ref, computed, watch } from 'vue'

defineProps({
    users: {
        type: Object,
        required: true
    },
    roles1: {
        type: Object,
        required: true
    },
});

const page = usePage();
let search = ref(usePage().props.search);
let pageNumber = ref(1);

let usersUrl = computed(() => {
    let url = new URL(route("users.index"));
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
    () => usersUrl.value,
    (updatedUsersUrl) => {
        router.visit(updatedUsersUrl, {
            preserveScroll: true,
            preserveState: true,
            replace: true,
        });
    }
);

const deleteForm = useForm({});

const deleteUser = (usersId) => {
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
            deleteForm.delete(route("users.destroy", usersId), {
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

    <Head title="Users List" />
    <AuthenticatedLayout>
        <DefaultLayout>
            <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="pb-4 px-5">
                    <div class="flex flex-col justify-between sm:flex-row mt-4">
                        <InputGroup v-model="search" type="text" autocomplete="off" placeholder="Buscar..." autofocus
                            customClasses="block" />
                        <div class="mt-4 sm:ml-16 sm:flex-none">
                            <Link v-if="page.props.can.product_create" :href="route('users.create')"
                                class="inline-flex items-center justify-center rounded bg-primary px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">
                            Nuevo usuario
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Table Header -->
                <div
                    class="grid grid-cols-3 border-t border-stroke py-4.5 px-4 dark:border-strokedark sm:grid-cols-4 md:px-6 2xl:px-7.5">
                    <div class="col-span-1 flex items-center">
                        <p class="font-medium">Nombre</p>
                    </div>
                    <div class="col-span-1 flex items-center">
                        <p class="font-medium">Correo electronico</p>
                    </div>

                    <div class="col-span-1 flex items-center">
                        <p class="font-medium">Acciones</p>
                    </div>
                </div>

                <!-- Table Rows -->
                <div v-for="user in users.data" :key="user.id"
                    class="grid grid-cols-3 border-t border-stroke py-4.5 px-4 dark:border-strokedark sm:grid-cols-4 md:px-6 2xl:px-7.5">
                    <div class="col-span-1 flex items-center">
                        <p class="text-sm font-medium text-black dark:text-white">{{ user.name }}</p>
                    </div>

                    <div class="col-span-1 flex items-center">
                        <p class="text-sm font-medium text-black dark:text-white">{{ user.email }}</p>
                    </div>
                    <div class="col-span-1 flex items-center">
                        <!-- Table Rows -->
                        <Link v-if="page.props.can.product_edit" :href="route('users.edit', user.id)"
                            class="text-indigo-600 hover:text-indigo-900">
                        Edit
                        </Link>
                        <button v-if="page.props.can.product_create" @click="deleteUser(user.id)"
                            class="ml-2 text-indigo-600 hover:text-indigo-900">
                            Delete
                        </button>
                    </div>

                </div>

            </div>

            <Pagination :data="users" :updatedPageNumber="updatedPageNumber" />
        </DefaultLayout>
    </AuthenticatedLayout>
</template>
