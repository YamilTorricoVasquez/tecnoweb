<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { Head, useForm, usePage } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import DefaultCard from '@/Components/Forms/DefaultCard.vue'
import InputGroup from '@/Components/Forms/InputGroup.vue'

const supplier = usePage().props.supplier;

defineProps({
    supplier: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    name: supplier.data.name, // Asumiendo que la propiedad `name` está presente en el objeto `category`
    nombre_empresa: supplier.data.nombre_empresa,
    phone: supplier.data.phone,
});

const updateSupplier = () => {
    form.put(route("suppliers.update", supplier.data.id), {
        preserveScroll: true,
    });
};
</script>

<template>

    <Head title="Edit Supplier" />

    <AuthenticatedLayout>
        <DefaultLayout>
            <div class="grid grid-cols-1">
                <div class="flex flex-col">
                    <DefaultCard cardTitle="Edit Supplier">
                        <form @submit.prevent="updateSupplier">
                            <div class="p-6.5">

                                <div class="mb-4.5">
                                    <InputGroup v-model="form.name" label="Nombre del proveedor" type="text"
                                        placeholder="Enter supplier name" customClasses="mb-4.5" />
                                    <InputError :message="form.errors.name" class="mt-2" />
                                </div>
                                <div class="mb-4.5">
                                    <InputGroup v-model="form.nombre_empresa" label="Nombre de la empresa" type="text"
                                        placeholder="Ingrese el nombre de la empresa" customClasses="mb-4.5" />
                                    <InputError :message="form.errors.nombre_empresa" class="mt-2" />
                                </div>
                                <div class="mb-4.5">
                                    <InputGroup v-model="form.phone" label="Telefono" type="text"
                                        placeholder="Ingrese el telefono del proveedor" customClasses="mb-4.5" />
                                    <InputError :message="form.errors.phone" class="mt-2" />
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
