<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import Pagination from "@/Components/Pagination.vue";
import InputGroup from '@/Components/Forms/InputGroup.vue'
import DefaultCard from '@/Components/Forms/DefaultCard.vue'
import { ref } from 'vue';
import SelectGroupTwo from '@/Components/Forms/SelectGroup/SelectGroupTwo.vue'
import InputError from '@/Components/InputError.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'; // Verifica la ruta
import Create from '@/Pages/Cliente/Create.vue'; // Ajusta la ruta según tu estructura

import { Head, useForm, usePage } from '@inertiajs/vue3';
const notaventas = usePage().props.notaventas;
defineProps({
    products: {
        type: Object,
        required: true
    },
    /*notaventas: {
        type: Object,
        required: true
    },*/
    notaventas: {
        type: Object,
        required: true, // Asegúrate de recibirlo como obligatorio
    },
    /* users: {
        type: Object,
        required: true
    }*/
});

let sections = ref({});

const form = useForm({
    cantidad: "",
    //  precio_venta: "",
    id_nota_venta: notaventas.id,
    id_producto: "",
    nombre_cliente: notaventas.cliente.nombre,
    apellido_cliente: notaventas.cliente.apellido,
    //  user_id: "",
    // supplier_id: "",

})


const handleFileUpload = (event) => {
    form.image = event.target.files[0];
}

const createDetalleVenta = () => {
    form.post(route('detalleventas.store'));
}

</script>

<template>

    <Head title="Detalle venta" />
    <AuthenticatedLayout>
        <DefaultLayout>
            <div class="grid grid-cols-1">
                <div class="flex flex-col">
                    <!-- Cabecera con datos del cliente -->
                    <div class="mb-6 p-4 bg-gray-100 dark:bg-gray-800 rounded shadow-md">
                        <h2 class="text-lg font-semibold text-black dark:text-white mb-2">Información del Cliente</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <p class="text-sm text-gray-700 dark:text-gray-300"><strong>ID Nota de Venta:</strong>
                                    {{ form.id_nota_venta }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Nombre del Cliente:</strong>
                                    {{ form.nombre_cliente }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Apellidos del
                                        Cliente:</strong>
                                    {{ form.apellido_cliente }}</p>
                            </div>
                            <!-- Puedes agregar más datos aquí -->
                            <div>
                                <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Teléfono:</strong> {{
                                    notaventas.cliente.telefono || 'No disponible' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Dirección:</strong> {{
                                    notaventas.cliente.direccion || 'No disponible' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form Start -->
                    <DefaultCard cardTitle="Agregar Detalle de venta">
                        <form @submit.prevent="createDetalleVenta">
                            <div class="p-6.5">
                                <!-- Contact Form Start
                                <div class="mb-4.5">
                                    <label class="mb-2.5 block text-black dark:text-white">ID Nota de Venta</label>
                                    <p
                                        class="relative z-20 w-full rounded border border-stroke bg-gray-100 py-3 px-5 text-gray-700 dark:text-gray-300 dark:bg-gray-700 cursor-not-allowed">
                                        {{ form.id_nota_venta }}
                                    </p>
                                    <InputError :message="form.errors.id_nota_venta" class="mt-2" />
                                </div>
                                <div class="mb-4.5">
                                    <label class="mb-2.5 block text-black dark:text-white">Nombre del Cliente</label>
                                    <p
                                        class="relative z-20 w-full rounded border border-stroke bg-gray-100 py-3 px-5 text-gray-700 dark:text-gray-300 dark:bg-gray-700 cursor-not-allowed">
                                        {{ form.nombre_cliente }}
                                    </p>
                                    <InputError :message="form.errors.nombre_cliente" class="mt-2" />
                                </div> -->

                                <!-- Otros campos del formulario -->
                                <div class="mb-4.5">
                                    <InputGroup v-model="form.cantidad" label="Cantidad" type="integer"
                                        placeholder="Introduzca el nombre del producto" />
                                    <InputError :message="form.errors.cantidad" class="mt-2" />
                                </div>
                                <!-- Otros campos del formulario 
                                <div class="mb-4.5">
                                    <InputGroup v-model="form.precio_venta" label="Precio de venta" type="decimal"
                                        placeholder="Introduzca el precio de venta" />
                                    <InputError :message="form.errors.precio_venta" class="mt-2" />
                                </div>-->

                                <div class="mb-4.5">
                                    <label class="mb-2.5 block text-black dark:text-white">Producto</label>
                                    <div class="relative z-20 bg-transparent dark:bg-form-input">
                                        <select v-model="form.id_producto" id="id_producto"
                                            class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                            :class="{
                                                ' text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300'
                                                    : form.errors.id_producto
                                            }">
                                            <option value="" disabled selected>Seleccionar un producto</option>
                                            <option v-for="item in products.data" :key="item.id" :value="item.id">
                                                {{ item.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <InputError :message="form.errors.id_producto" class="mt-2" />
                                </div>

                                <button type="submit"
                                    class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                                    Guardar
                                </button>
                            </div>
                        </form>
                    </DefaultCard>
                    <!-- Contact Form End -->
                </div>
            </div>
        </DefaultLayout>
    </AuthenticatedLayout>
</template>
