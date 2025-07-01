<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { Head, useForm, usePage } from "@inertiajs/vue3";
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
</script>

<template>

    <Head title="Edit PaymentMethod" />

    <AuthenticatedLayout>
        <DefaultLayout>
            <div class="grid grid-cols-1">
                <div class="flex flex-col">
                    <DefaultCard cardTitle="Edit PaymentMethod">
                        <form @submit.prevent="updatePaymentMethod">
                            <div class="p-6.5">

                                <!-- Campo de Fecha -->
                                <div class="mb-4.5">
                                    <InputGroup v-model="form.metodo" label="Metodo de pago" type="string" />
                                    <InputError :message="form.errors.metodo" class="mt-2" />
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
