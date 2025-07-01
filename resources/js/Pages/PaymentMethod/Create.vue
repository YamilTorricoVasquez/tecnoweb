<template>

    <Head title="Add Payment Method" />
    <DefaultLayout>
        <div class="grid grid-cols-1">
            <div class="flex flex-col">
                <!-- Formulario de Categorías -->
                <DefaultCard cardTitle="Add Payment Method">
                    <form @submit.prevent="createPaymentMethod">
                        <div class="p-6.5">
                            <!-- Campo de Fecha -->
                            <div class="mb-4.5">
                                <InputGroup v-model="form.metodo" label="Metodo de pago" type="string" placeholder="Enter payment method name" />
                                <InputError :message="form.errors.metodo" class="mt-2" />
                            </div>

                            <!-- Botón de Guardar -->
                            <button type="submit"
                                class="flex w-full justify-center rounded bg-primary p-3 font-medium text-white hover:bg-opacity-90">
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
    metodo: ""
});

const createPaymentMethod = () => {
    form.post(route('paymentmethods.store'));
};
</script>