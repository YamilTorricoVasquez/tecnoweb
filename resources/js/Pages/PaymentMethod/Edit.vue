<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import {Link, Head, useForm, usePage } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import DefaultCard from '@/Components/Forms/DefaultCard.vue'
import InputGroup from '@/Components/Forms/InputGroup.vue'

const paymentmethod = usePage().props.paymentmethod;

defineProps({
    paymentmethod: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    metodo: paymentmethod.data.metodo, // Asumiendo que la propiedad `name` está presente en el objeto `category`
});

const updatePaymentMethod = () => {
    form.put(route("paymentmethods.update", paymentmethod.data.id), {
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

    <Head title="Editar Metodo de Pago" />

    <AuthenticatedLayout>
        <DefaultLayout>
            <div class="grid grid-cols-1">
                <div class="flex flex-col">
                           <Link
  :href="route('paymentmethods.index')"
  class="inline-flex items-center rounded bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-300 mb-4"
>
  ← Volver al listado
</Link>
                    <DefaultCard cardTitle="Editar Metodo de Pago">
                        <form @submit.prevent="updatePaymentMethod">
                            <div class="p-6.5">

                                <!-- Campo de Fecha -->
                                <div class="mb-4.5">
                                    <InputGroup v-model="form.metodo" label="Metodo de pago" 
                                    @input="form.metodo = capitalizeWords(form.metodo)"
                                    type="string" />
                                    <InputError :message="form.errors.metodo" class="mt-2" />
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
