<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import {Link, Head, useForm, usePage } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import DefaultCard from '@/Components/Forms/DefaultCard.vue'
import InputGroup from '@/Components/Forms/InputGroup.vue'

const inventorydetail = usePage().props.inventorydetail;

defineProps({
    inventorydetail: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    cantidad_minima: inventorydetail.data.cantidad_minima, // Asumiendo que la propiedad `name` está presente en el objeto `category`
});

const updateInventoryDetail = () => {
    form.put(route("inventorydetails.update", inventorydetail.data.id), {
        preserveScroll: true,
    });
};
</script>

<template>

    <Head title="Editar Detalle de inventario" />

    <AuthenticatedLayout>
        <DefaultLayout>
            <div class="grid grid-cols-1">
                <div class="flex flex-col">
                    <Link
  :href="route('inventorydetails.index')"
  class="inline-flex items-center rounded bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-300 mb-4"
>
  ← Volver al listado
</Link>
                    <DefaultCard cardTitle="Editar Detalle de inventario">
                        <form @submit.prevent="updateInventoryDetail">
                            <div class="p-6.5">

                                <!-- Campo de Fecha -->
                                <div class="mb-4.5">
                                    <InputGroup v-model="form.cantidad_minima" 
                                   
                                    label="cantidad minima" type="integer" />

                                    <InputError :message="form.errors.cantidad_minima" class="mt-2" />
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
