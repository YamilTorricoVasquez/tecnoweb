<template>
  <Head title="Registrar Categorias" />
  <DefaultLayout>
    <div class="grid grid-cols-1">
      <div class="flex flex-col">
        <Link
  :href="route('categories.index')"
  class="inline-flex items-center rounded bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-300 mb-4"
>
  ← Volver al listado
</Link>
        <!-- Formulario de Categorías -->
        <DefaultCard cardTitle="Registrar Categorías" >
          <form @submit.prevent="createCategory">
            <div class="p-6.5">
              <!-- Campo de Nombre -->
              <div class="mb-4.5">
                
                <InputGroup
                  v-model="form.name"
                    @input="form.name = capitalizeWords(form.name)"
                  label="Nombre de la categoria"
                  type="text"
                  placeholder="Ingrese el nombre de la categoría"
                />
                <InputError :message="form.errors.name" class="mt-2" />
              </div>

              <!-- Botón de Guardar -->
              <button
                type="submit"
                class="flex w-full justify-center rounded bg-primary p-3 font-medium text-white hover:bg-opacity-90"
              >
                Registrar
              </button>
            </div>
          </form>
        </DefaultCard>
      </div>
    </div>
  </DefaultLayout>
</template>

<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import InputGroup from '@/Components/Forms/InputGroup.vue';
import DefaultCard from '@/Components/Forms/DefaultCard.vue';
import InputError from '@/Components/InputError.vue';
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
const form = useForm({
  name: ""
});
const capitalizeWords = (input) => {
  return input.replace(/\b\w/g, (char) => char.toUpperCase());
};

const capitalizeFirstLetter = (input) => {
  return input.charAt(0).toUpperCase() + input.slice(1).toLowerCase();
};
const createCategory = () => {
  form.post(route('categories.store'));
};
</script>
