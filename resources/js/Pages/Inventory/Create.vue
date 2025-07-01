<template>

    <Head title="Add Inventory" />
    <DefaultLayout>
        <div class="grid grid-cols-1">
            <div class="flex flex-col">
                <!-- Formulario de Categorías -->
                <DefaultCard cardTitle="Add Inventory">
                    <form @submit.prevent="createInventory">
                        <div class="p-6.5">
                            <!-- Campo de Fecha -->
                            <div class="mb-4.5">
                                <InputGroup v-model="form.fecha" label="Date" type="date" />
                                <InputError :message="form.errors.fecha" class="mt-2" />
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
    fecha: ""
});

const createInventory = () => {
    form.post(route('inventories.store'));
};
</script>