<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { Head, useForm, usePage } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import DefaultCard from '@/Components/Forms/DefaultCard.vue'
import InputGroup from '@/Components/Forms/InputGroup.vue'

const inventorie = usePage().props.inventorie;

defineProps({
    inventorie: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    fecha: inventorie.data.fecha, // Asumiendo que la propiedad `name` está presente en el objeto `category`
});

const updateInventory = () => {
    form.put(route("inventories.update", inventorie.data.id), {
        preserveScroll: true,
    });
};
</script>

<template>

    <Head title="Edit Inventory" />

    <AuthenticatedLayout>
        <DefaultLayout>
            <div class="grid grid-cols-1">
                <div class="flex flex-col">
                    <DefaultCard cardTitle="Edit Inventory">
                        <form @submit.prevent="updateInventory">
                            <div class="p-6.5">

                                <!-- Campo de Fecha -->
                                <div class="mb-4.5">
                                    <InputGroup v-model="form.fecha" label="Date" type="date" />
                                    <InputError :message="form.errors.fecha" class="mt-2" />
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
