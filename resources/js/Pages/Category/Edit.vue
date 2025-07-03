<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { Head, useForm, usePage } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import DefaultCard from '@/Components/Forms/DefaultCard.vue'
import InputGroup from '@/Components/Forms/InputGroup.vue'
import { Link } from '@inertiajs/vue3';

const category = usePage().props.category;

defineProps({
  category: {
    type: Object,
    required: true,
  },
});
const capitalizeWords = (input) => {
  return input.replace(/\b\w/g, (char) => char.toUpperCase());
};

const capitalizeFirstLetter = (input) => {
  return input.charAt(0).toUpperCase() + input.slice(1).toLowerCase();
};
const form = useForm({
  name: category.data.name, // Asumiendo que la propiedad `name` está presente en el objeto `category`
});

const updateCategory = () => {
  form.put(route("categories.update", category.data.id), {
    preserveScroll: true,
  });
};
</script>

<template>

  <Head title="Editar Categorias" />

  <AuthenticatedLayout>
    <DefaultLayout>
      <div class="grid grid-cols-1">
        <div class="flex flex-col">
          
         <Link
  :href="route('categories.index')"
  class="inline-flex items-center rounded bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-300 mb-4"
>
  ← Volver al listado
</Link>
          <DefaultCard cardTitle="Editar Categorías">
            <form @submit.prevent="updateCategory">
              <div class="p-6.5">

                <div class="mb-4.5">
                  <InputGroup v-model="form.name" label="Nombre de la categoria" type="text" placeholder="Ingrese el nombre de la categoria"
                  @input="form.name = capitalizeWords(form.name)"
                    customClasses="mb-4.5" />
                  <InputError :message="form.errors.name" class="mt-2" />
                </div>

                <button type="submit"
                  class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                  Editar
                </button>
              </div>
            </form>
          </DefaultCard>
        </div>
      </div>
    </DefaultLayout>
  </AuthenticatedLayout>
</template>
