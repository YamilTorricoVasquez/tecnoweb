<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import Pagination from "@/Components/Pagination.vue"
import InputGroup from '@/Components/Forms/InputGroup.vue'
import { Head, Link, useForm, usePage, router } from "@inertiajs/vue3";
import Swal from 'sweetalert2'

import { ref, computed, watch } from 'vue'

const page = usePage();

defineProps({
  roles: {
    type: Object,
    required: true,
  },
});

let search = ref(usePage().props.search), pageNumber = ref(1);

let rolessUrl = computed(() => {
  let url = new URL(route("roles.index"));
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
  () => rolessUrl.value,
  (updatedrolessUrl) => {
    router.visit(updatedrolessUrl, {
      preserveScroll: true,
      preserveState: true,
      replace: true,
    });
  }
);


const deleteProduct = (productId) => {
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
      deleteForm.delete(route("products.destroy", productId));
      Swal.fire({
        title: "Deleted!",
        text: "Your data has been deleted.",
        icon: "success"
      });
    }
  });

}

const deleteForm = useForm({});

const deleteRole = (id) => {
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
      deleteForm.delete(route("roles.destroy", id), {
        preserveScroll: true,
      });
      Swal.fire({
        title: "Deleted!",
        text: "Your file has been deleted.",
        icon: "success"
      });
    }
  });

};
const capitalizeWords = (input) => {
  return input.replace(/\b\w/g, (char) => char.toUpperCase());
};
</script>

<template>

  <Head title="Lista de Roles" />

  <AuthenticatedLayout>
    <DefaultLayout>
      <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="pb-4 px-5">
          <div class="flex flex-col justify-between sm:flex-row mt-4">
            <InputGroup v-model="search" 
            @input="search = capitalizeWords(search)"
            type="text" autocomplete="off" placeholder="buscar..." autofocus
              customClasses="block" />

            <div class="mt-4 sm:ml-16 sm:flex-none">
              <Link v-if="page.props.can.crear_roles" :href="route('roles.create')" class="
              inline-flex items-center justify-center rounded
              bg-primary px-4 py-2 text-sm font-medium text-white 
              shadow-sm hover:bg-indigo-700">
              Registrar rol
              </Link>
            </div>

          </div>
        </div>
        <!-- Table Header -->
        <div class="grid grid-cols-5 border-t border-stroke py-4.5 px-4 
               dark:border-strokedark md:px-6 2xl:px-7.5">
          <div class="col-span-4 flex items-center">
            <p class="font-medium">Titulo</p>
          </div>
          <div class="col-span-1 flex items-center">
            <p class="font-medium">Acciones</p>
          </div>
        </div>

        <!-- Table Rows -->
        <div v-for="role in roles.data" :key="roles.id" class="grid grid-cols-5 border-t border-stroke 
                 py-4.5 px-4 dark:border-strokedark md:px-6 2xl:px-7.5">
          <div class="col-span-4 hidden items-center sm:flex">
            
            <p class="text-sm font-medium text-black dark:text-white">{{ role.title }}</p>
          </div>
          <div class="col-span-1 flex items-center">
            <Link v-if="page.props.can.editar_roles" :href="route('roles.edit', role.id)
              " class="text-indigo-600 hover:text-indigo-900">
            Editar
            </Link>
            <button v-if="page.props.can.editar_roles" @click="deleteRole(role.id)"
              class="ml-2 text-indigo-600 hover:text-indigo-900">
              Eliminar
            </button>

          </div>
        </div>
      </div>
      <Pagination :data="roles" :updatedPageNumber="updatedPageNumber" />
    </DefaultLayout>

  </AuthenticatedLayout>
</template>