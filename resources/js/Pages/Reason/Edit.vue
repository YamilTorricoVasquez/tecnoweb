<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import {Link, Head, useForm, usePage } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import DefaultCard from '@/Components/Forms/DefaultCard.vue'
import InputGroup from '@/Components/Forms/InputGroup.vue'

const reason = usePage().props.reason;

defineProps({
    reason: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    descripcion: reason.data.descripcion, // Asumiendo que la propiedad `name` está presente en el objeto `category`
});

const updateReason = () => {
    form.put(route("reasons.update", reason.data.id), {
        preserveScroll: true,
    });
};
const capitalizeWords = (input) => {
  return input.replace(/\b\w/g, (char) => char.toUpperCase());
};

const capitalizeFirstLetter = (input) => {
  return input.charAt(0).toUpperCase() + input.slice(1).toLowerCase();
};
</script>

<template>

    <Head title="Editar Razon" />

    <AuthenticatedLayout>
        <DefaultLayout>
            <div class="grid grid-cols-1">
                <div class="flex flex-col">
                    <Link
  :href="route('reasons.index')"
  class="inline-flex items-center rounded bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-300 mb-4"
>
  ← Volver al listado
</Link>
                    <DefaultCard cardTitle="Editar Razon">
                        <form @submit.prevent="updateReason">
                            <div class="p-6.5">

                                <!-- Campo de Fecha -->
                                <div class="mb-4.5">
                                    <InputGroup v-model="form.descripcion" label="Descripcion de la razon"
                                    @input="form.descripcion = capitalizeWords(form.descripcion)"
                                    type="string" />
                                    <InputError :message="form.errors.descripcion" class="mt-2" />
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
