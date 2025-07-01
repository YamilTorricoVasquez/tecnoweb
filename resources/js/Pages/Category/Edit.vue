<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { Head, useForm, usePage } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import DefaultCard from '@/Components/Forms/DefaultCard.vue'
import InputGroup from '@/Components/Forms/InputGroup.vue'

const category = usePage().props.category;

defineProps({
  category: {
    type: Object,
    required: true,
  },
});

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

  <Head title="Edit Category" />

  <AuthenticatedLayout>
    <DefaultLayout>
      <div class="grid grid-cols-1">
        <div class="flex flex-col">
          <DefaultCard cardTitle="Edit Category">
            <form @submit.prevent="updateCategory">
              <div class="p-6.5">

                <div class="mb-4.5">
                  <InputGroup v-model="form.name" label="Category Name" type="text" placeholder="Enter category name"
                    customClasses="mb-4.5" />
                  <InputError :message="form.errors.name" class="mt-2" />
                </div>

                <button type="submit"
                  class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                  Save
                </button>
              </div>
            </form>
          </DefaultCard>
        </div>
      </div>
    </DefaultLayout>
  </AuthenticatedLayout>
</template>
