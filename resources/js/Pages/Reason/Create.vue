<template>

    <Head title="Add Reason" />
    <DefaultLayout>
        <div class="grid grid-cols-1">
            <div class="flex flex-col">
                <!-- Formulario de Categorías -->
                <DefaultCard cardTitle="Add Reason">
                    <form @submit.prevent="createReason">
                        <div class="p-6.5">
                            <!-- Campo de Fecha -->
                            <div class="mb-4.5">
                                <InputGroup v-model="form.descripcion" label="Descripcion" type="string" placeholder="Ingrese una descripcion" />
                                <InputError :message="form.errors.descripcion" class="mt-2" />
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
    descripcion: ""
});

const createReason = () => {
    form.post(route('reasons.store'));
};
</script>