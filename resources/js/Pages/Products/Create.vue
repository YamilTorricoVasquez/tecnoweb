<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import Pagination from "@/Components/Pagination.vue";
import InputGroup from '@/Components/Forms/InputGroup.vue'
import DefaultCard from '@/Components/Forms/DefaultCard.vue'
import { ref } from 'vue';
import SelectGroupTwo from '@/Components/Forms/SelectGroup/SelectGroupTwo.vue'
import InputError from '@/Components/InputError.vue';

import { Head, useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';

defineProps({
  categories: {
    type: Object,
    required: true
  },
});

let sections = ref({});

const form = useForm({
  name: "",
  descripcion: "",
  category_id: "",
});

const capitalizeWords = (input) => {
  return input.replace(/\b\w/g, (char) => char.toUpperCase());
};

const capitalizeFirstLetter = (input) => {
  return input.charAt(0).toUpperCase() + input.slice(1).toLowerCase();
};

const productoList = ref([
  {
    name: "",
    descripcion: "",
    category_id: "",
  }
]);

const addProductos = () => {
  productoList.value.push({
    name: "",
    descripcion: "",
    category_id: "",
  });
};

const removeProducto = (index) => {
  if (productoList.value.length > 1) {
    productoList.value.splice(index, 1);
  } else {
    console.log("No se puede eliminar la última fila.");
  }
};

const createProduct = async () => {
  try {
    form.errors = {};

    // Verificar duplicados
    let hasDuplicates = false;
    const existingProducts = await Promise.all(productoList.value.map(async (producto) => {
      if (!producto.name || !producto.descripcion || !producto.category_id) {
        return null;
      }
      const response = await fetch(route('products.check') + `?name=${encodeURIComponent(producto.name)}`);
      const data = await response.json();
      return data.exists ? producto.name : null;
    }));
    const duplicatedProducts = existingProducts.filter(name => name !== null);
    if (duplicatedProducts.length > 0) {
      duplicatedProducts.forEach(duplicatedProduct => {
        form.errors[`producto_duplicate_${duplicatedProduct}`] = `El producto "${duplicatedProduct}" ya existe en el sistema.`;
      });
      hasDuplicates = true;
    }
    if (hasDuplicates) return;

    // Validar campos vacíos
    let hasEmptyFields = false;
    for (const [index, producto] of productoList.value.entries()) {
      if (!producto.name || !producto.descripcion || !producto.category_id) {
        hasEmptyFields = true;
        if (!producto.name) {
          form.errors[`producto_${index}_name`] = 'El nombre del producto es obligatorio';
        }
        if (!producto.descripcion) {
          form.errors[`producto_${index}_descripcion`] = 'La descripción del producto es obligatoria';
        }
        if (!producto.category_id) {
          form.errors[`producto_${index}_category_id`] = 'La categoría del producto es obligatoria';
        }
      }
    }
    if (hasEmptyFields) return;

    // Enviar cada producto CLONADO uno por uno
    for (const producto of productoList.value) {
      const productoClonado = { ...producto };
      await useForm({ productos: productoList.value }).post(route('products.storeMultiple'), {
        onSuccess: () => {
          productoList.value = [{ name: "", descripcion: "", category_id: "" }];
          form.errors = {};
          console.log("Productos creados exitosamente");
        }
      });
    }

    // Limpiar la lista después de crear
    productoList.value = [
      {
        name: "",
        descripcion: "",
        category_id: "",
      }
    ];
    form.errors = {};
    console.log("Productos creados exitosamente");
  } catch (error) {
    console.error("Error al crear productos:", error);
  }
};
</script>

<template>
  <Head title="Registrar Medicamentos" />
  <AuthenticatedLayout>
    <DefaultLayout>
      <div class="grid grid-cols-1">
        <div class="flex flex-col">
          <Link
  :href="route('products.index')"
  class="inline-flex items-center rounded bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-300 mb-4"
>
  ← Volver al listado
</Link>
          <!-- Contact Form Start -->
          <DefaultCard cardTitle="Registrar Medicamentos">
            <form @submit.prevent="createProduct">
              <div class="p-6.5">
                <table class="table-auto w-full border-collapse border border-stroke mb-4.5">
                  <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700">
                      <th class="border border-stroke px-4 py-2 text-left">Nombre del medicamento</th>
                      <th class="border border-stroke px-4 py-2 text-left">Descripcion del medicamento</th>
                      <th class="border border-stroke px-4 py-2 text-left">Categoria del medicamento</th>
                      <th class="border border-stroke px-4 py-2 text-left">Acción</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(producto, index) in productoList" :key="index"
                      class="hover:bg-gray-50 dark:hover:bg-gray-800">
                      <td class="border border-stroke px-4 py-2">
                        <InputGroup v-model="producto.name" type="text" placeholder="Introduzca el nombre del producto"
                          @input="producto.name = capitalizeWords(producto.name);" />
                        <InputError :message="form.errors[`producto_${index}_name`]" class="mt-2" />
                        <div v-if="form.errors[`producto_duplicate_${producto.name}`]" class="error text-red-500 mt-2">
                          {{ form.errors[`producto_duplicate_${producto.name}`] }}
                        </div>
                      </td>
                      <td class="border border-stroke px-4 py-2">
                        <InputGroup v-model="producto.descripcion" type="text" placeholder="Introduzca una descripcion"
                          @input="producto.descripcion = capitalizeFirstLetter(producto.descripcion)" />
                        <InputError :message="form.errors[`producto_${index}_descripcion`]" class="mt-2" />
                      </td>
                      <td class="border border-stroke px-4 py-2">
                        <select v-model="producto.category_id" id="category_id"
                          class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                          :class="{
                            'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300': form.errors.category_id
                          }">
                          <option value="" disabled selected>Seleccionar categoria</option>
                          <option v-for="item in categories.data" :key="item.id" :value="item.id">
                            {{ item.name }}
                          </option>
                        </select>
                        <InputError :message="form.errors[`producto_${index}_category_id`]" class="mt-2" />
                      </td>
                      <td class="border border-stroke px-4 py-2 text-center">
                        <button @click.prevent="removeProducto(index)"
                          class="bg-blue-500 text-white px-4 py-2 rounded mb-4">
                          Eliminar
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <button @click.prevent="addProductos" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">Añadir
                  Medicamento</button>
                <button type="submit"
                  class="bg-primary text-white px-6 py-3 rounded font-medium w-full">
                  Registrar
                </button>
              </div>
            </form>
          </DefaultCard>
          <!-- Contact Form End -->
        </div>
      </div>
    </DefaultLayout>
  </AuthenticatedLayout>
</template>