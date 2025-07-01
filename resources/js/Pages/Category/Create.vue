<template>
  <Head title="Add Category" />
  <DefaultLayout>
    <div class="grid grid-cols-1">
      <div class="flex flex-col">
        <!-- Formulario de Categorías -->
        <DefaultCard cardTitle="Add Category">
          <form @submit.prevent="createCategory">
            <div class="p-6.5">
              <!-- Campo de Nombre -->
              <div class="mb-4.5">
                <InputGroup
                  v-model="form.name"
                  label="Category Name"
                  type="text"
                  placeholder="Enter category name"
                />
                <InputError :message="form.errors.name" class="mt-2" />
              </div>

              <!-- Botón de Guardar -->
              <button
                type="submit"
                class="flex w-full justify-center rounded bg-primary p-3 font-medium text-white hover:bg-opacity-90"
              >
                Save
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

const form = useForm({
  name: ""
});

const createCategory = () => {
  form.post(route('categories.store'));
};
</script>
