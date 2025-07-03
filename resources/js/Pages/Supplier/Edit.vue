<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { Head, useForm, usePage } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import DefaultCard from '@/Components/Forms/DefaultCard.vue'
import InputGroup from '@/Components/Forms/InputGroup.vue'
import { Link } from '@inertiajs/vue3';


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

    <Head title="Editar Proveedores" />

    <AuthenticatedLayout>
        <DefaultLayout>
            <div class="grid grid-cols-1">
                <div class="flex flex-col">
                    <Link
  :href="route('suppliers.index')"
  class="inline-flex items-center rounded bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-300 mb-4"
>
  ← Volver al listado
</Link>
                    <DefaultCard cardTitle="Editar proveedores">
                        <form @submit.prevent="updateSupplier">
                            <div class="p-6.5">

                                <div class="mb-4.5">
                                    <InputGroup v-model="form.name" label="Nombre del proveedor" type="text"
                                        placeholder="Ingrese el nombre del proveedor" customClasses="mb-4.5" />
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
