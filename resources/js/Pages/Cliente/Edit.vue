<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { Head, useForm, usePage } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import DefaultCard from '@/Components/Forms/DefaultCard.vue'
import InputGroup from '@/Components/Forms/InputGroup.vue'

const cliente = usePage().props.cliente;

defineProps({
    cliente: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    nombre: cliente.data.nombre, // Asumiendo que la propiedad `name` está presente en el objeto `category`
    apellido: cliente.data.apellido,
});

const updateCliente = () => {
    form.put(route("clientes.update", cliente.data.id), {
        preserveScroll: true,
    });
};
</script>

<template>

    <Head title="Edit Cliente" />

    <AuthenticatedLayout>
        <DefaultLayout>
            <div class="grid grid-cols-1">
                <div class="flex flex-col">
                    <DefaultCard cardTitle="Edit Cliente">
                        <form @submit.prevent="updateCliente">
                            <div class="p-6.5">

                                <!-- Campo de Fecha -->
                                <div class="mb-4.5">
                                    <InputGroup v-model="form.nombre" label="Nombre" type="string" />
                                    <InputError :message="form.errors.nombre" class="mt-2" />
                                </div>
                                <div class="mb-4.5">
                                    <InputGroup v-model="form.apellido" label="Apellido" type="string" />
                                    <InputError :message="form.errors.apellido" class="mt-2" />
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
