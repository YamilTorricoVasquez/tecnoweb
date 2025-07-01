<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import Pagination from "@/Components/Pagination.vue";
import InputGroup from '@/Components/Forms/InputGroup.vue';
import DefaultCard from '@/Components/Forms/DefaultCard.vue';
import SelectGroupTwo from '@/Components/Forms/SelectGroup/SelectGroupTwo.vue';
import InputError from '@/Components/InputError.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'; // Verifica la ruta
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';

let sections = ref({});
defineProps({
    clientes: {
        type: Object,
        required: true
    },
    paymentmethods: {
        type: Object,
        required: true
    },


});
const clienteForm = useForm({
    nombre: "",
    apellido: "",
});

const notaVentaForm = useForm({
    cliente_id: "",
    paymentmethod_id: "",
});

const createClienteYNotaVenta = async () => {
    // Crear cliente
    await clienteForm.post(route('clientes.store'), {
        onSuccess: (response) => {
            // Obtener el ID del cliente recién creado
            const clienteId = response.props.cliente.id; // Ajusta según tu respuesta
            notaVentaForm.cliente_id = clienteId;

            // Crear nota de venta
            notaVentaForm.post(route('notaventas.store'));
        },
    });
};
</script>

<template>

    <Head title="Nota Venta y Cliente" />
    <AuthenticatedLayout>
        <DefaultLayout>
            <div class="grid grid-cols-1">
                <div class="flex flex-col">

                    <!-- Formulario combinado -->
                    <DefaultCard cardTitle="Agregar Cliente y Nota de Venta">
                        <form @submit.prevent="createClienteYNotaVenta">
                            <div class="p-6.5">

                                <!-- Formulario Cliente -->
                                <h2 class="mb-4 text-lg font-semibold">Datos del Cliente</h2>
                                <div class="mb-4.5">
                                    <InputGroup v-model="clienteForm.nombre" label="Nombre" type="string"
                                        placeholder="Ingrese el nombre" />
                                    <InputError :message="clienteForm.errors.nombre" class="mt-2" />
                                </div>
                                <div class="mb-4.5">
                                    <InputGroup v-model="clienteForm.apellido" label="Apellido" type="string"
                                        placeholder="Ingrese el apellido" />
                                    <InputError :message="clienteForm.errors.apellido" class="mt-2" />
                                </div>

                                <!-- Formulario Nota de Venta -->
                                <h2 class="mb-4 text-lg font-semibold">Datos de la Nota de Venta</h2>
                                <div class="mb-4.5">
                                    <label class="mb-2.5 block text-black dark:text-white">Método de Pago</label>
                                    <select v-model="notaVentaForm.paymentmethod_id" id="paymentmethod_id"
                                        class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                        <option value="" disabled selected>Seleccionar método de pago</option>
                                        <option v-for="item in paymentmethods.data" :key="item.id" :value="item.id">
                                            {{ item.metodo }}
                                        </option>
                                    </select>
                                    <InputError :message="notaVentaForm.errors.paymentmethod_id" class="mt-2" />
                                </div>

                                <!-- Botón para Guardar -->
                                <button type="submit"
                                    class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                                    Guardar Cliente y Nota de Venta
                                </button>
                            </div>
                        </form>
                    </DefaultCard>

                </div>
            </div>
        </DefaultLayout>
    </AuthenticatedLayout>
</template>
