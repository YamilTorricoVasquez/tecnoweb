<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import Pagination from "@/Components/Pagination.vue"
import InputGroup from '@/Components/Forms/InputGroup.vue'
import Swal from 'sweetalert2'

import { Head, Link, usePage, useForm, router } from '@inertiajs/vue3'
import { ref, computed, watch } from 'vue'

defineProps({
  inventorydetails: {
    type: Object,
    required: true
  }
})

const page = usePage();
let search = ref(usePage().props.search), pageNumber = ref(1);

let inventorydetailsUrl = computed(() => {
  let url = new URL(route("inventorydetails.index"));
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
  () => inventorydetailsUrl.value,
  (updatedinventorydetailsUrl) => {
    router.visit(updatedinventorydetailsUrl, {
      preserveScroll: true,
      preserveState: true,
      replace: true,
    });
  }
);


const deleteForm = useForm({});

const deleteInventoryDetail = (inventorydetailId) => {
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
      deleteForm.delete(route("inventorydetails.destroy", inventorydetailId), {
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

  <Head title="Inventory Detail List" />
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
            <p class="font-medium">Cantidad</p>
          </div>
          <div class="col-span-1 flex items-center">
            <p class="font-medium">Cantidad minima</p>
          </div>
          <div class="col-span-1 hidden items-center sm:flex">
            <p class="font-medium">Precio venta</p>
          </div>
          <div class="col-span-1 flex items-center">
            <p class="font-medium">Producto</p>
          </div>
          <div class="col-span-1 flex items-center">
            <p class="font-medium">Inventario</p>
          </div>

        </div>

        <!-- Table Rows -->
        <div v-for="inventorydetail in inventorydetails.data" :key="inventorydetail.id" class="grid grid-cols-5 border-t border-stroke 
                 py-4.5 px-4 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">

          <div class="col-span-1 hidden items-center sm:flex">
            <p class="text-sm font-medium text-black dark:text-white">{{ inventorydetail.cantidad }}</p>
          </div>
          <div class="col-span-1 hidden items-center sm:flex">
            <p class="text-sm font-medium text-black dark:text-white">{{ inventorydetail.cantidad_minima }}</p>
          </div>
          <div class="col-span-1 hidden items-center sm:flex">
            <p class="text-sm font-medium text-black dark:text-white">{{ inventorydetail.precio_venta }}</p>
          </div>
          <div class="col-span-1 hidden items-center sm:flex">
            <p class="text-sm font-medium text-black dark:text-white">{{ inventorydetail.product.name }}</p>
          </div>
          <!-- Fecha del inventario -->
          <div class="col-span-1 hidden items-center sm:flex">
            <p class="text-sm font-medium text-black dark:text-white">{{ inventorydetail.inventory.fecha }}</p>
          
          </div>
          <!-- Mostrar Proveedor 
          <div class="col-span-1 flex items-center">
            <p class="text-sm font-medium text-black dark:text-white">{{ product.supplier.name }}</p>
          </div>-->

          <!-- Mostrar Proveedor -->
          <div class="col-span-1 flex items-center">
            <Link v-if="page.props.can.inventorydetail_edit" :href="route('inventorydetails.edit', inventorydetail.id)"
              class="text-indigo-600 hover:text-indigo-900">
            Edit
            </Link>

            <!-- Mostrar Proveedor 
            <button v-if="page.props.can.product_delete" @click="deleteProduct(product.id)"
              class="ml-2 text-indigo-600 hover:text-indigo-900">
              Delete
            </button>-->

          </div>
        </div>
      </div>

      <Pagination :data="inventorydetails" :updatedPageNumber="updatedPageNumber" />
    </DefaultLayout>
  </AuthenticatedLayout>
</template>