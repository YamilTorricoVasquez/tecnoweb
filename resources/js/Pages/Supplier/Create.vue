<template>

    <Head title="Add Supplier" />
    <DefaultLayout>
        <div class="grid grid-cols-1">
            <div class="flex flex-col">
                <!-- Formulario de Categorías -->
                <DefaultCard cardTitle="Agregar Proveedor">
                    <form @submit.prevent="createSupplier">
                        <div class="p-6.5">
                            <!-- Campo de Nombre -->
                            <div class="mb-4.5">
                                <InputGroup v-model="form.name" label="Nombre del Proveedor" type="text" placeholder="
Ingrese el nombre del proveedor" />
                                <InputError :message="form.errors.name" class="mt-2" />
                            </div>
                            <div class="mb-4.5">
                                <InputGroup v-model="form.nombre_empresa" label="Nombre de la empresa" type="text"
                                    placeholder="
Ingrese el nombre de la empresa" />
                                <InputError :message="form.errors.nombre_empresa" class="mt-2" />
                            </div>
                            <div class="mb-4.5">
                                <InputGroup v-model="form.phone" label="teléfono" type="text" placeholder="
Ingrese el nombre de la empresa" />
                                <InputError :message="form.errors.phone" class="mt-2" />
                            </div>
                            <!-- Botón de Guardar -->
                            <button type="submit"
                                class="flex w-full justify-center rounded bg-primary p-3 font-medium text-white hover:bg-opacity-90">
                                Guardar
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
    name: "",
    nombre_empresa: "",
    phone: "",
});

const createSupplier = () => {
    form.post(route('suppliers.store'));
};
</script>