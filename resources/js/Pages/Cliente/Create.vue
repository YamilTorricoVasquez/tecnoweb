<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import InputGroup from '@/Components/Forms/InputGroup.vue';
import DefaultCard from '@/Components/Forms/DefaultCard.vue';
import InputError from '@/Components/InputError.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, computed } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';

// Props de entrada
const props = defineProps({
    clientes: { type: Array, required: true },
    paymentmethods: { type: Array, required: true },
    products: { type: Array, required: true },
});

// Formularios para cliente y nota de venta
const clienteForm = useForm({
    nombre: "",
    apellido: ""
});

const notaVentaForm = useForm({
    cliente_id: "",
    paymentmethod_id: ""
});

// Lista de detalles de venta
const detalleVentaList = ref([{
    id_producto: "",
    cantidad: "",
    precio_venta: 0,
    total: 0
}]);

// Método para añadir un nuevo detalle de venta
const addDetalleVenta = () => {
    detalleVentaList.value.push({
        id_producto: "",
        cantidad: "",
        precio_venta: 0,
        total: 0
    });
};

// Método para eliminar un detalle de venta
const removeDetalleVenta = (index) => {
    //  detalleVentaList.value.splice(index, 1);
    if (detalleVentaList.value.length > 1) {
        detalleVentaList.value.splice(index, 1);
    } else {
        console.log("No se puede eliminar la última fila.");
    }
};


// Método para actualizar precio y total dinámicamente
const updateDetalleVenta = (detalle) => {
    const selectedProduct = props.products.find(product => product.id === detalle.id_producto);
    if (selectedProduct) {
        detalle.precio_venta = selectedProduct.precio_venta;
        detalle.total = detalle.cantidad * detalle.precio_venta;
    } else {
        detalle.precio_venta = 0;
        detalle.total = 0;
    }
};

// Computed para calcular el total general
const totalGeneral = computed(() => {
    return detalleVentaList.value.reduce((sum, detalle) => sum + detalle.total, 0);
});

const createClienteYNotaVenta = async () => {
    // Limpiar errores previos
    notaVentaForm.errors = {};
    clienteForm.errors = {}; // Si también estás validando cliente
    // Bandera para saber si hay errores
    let hasErrors = false;
    console.log(hasErrors);
    // Validar los campos de todos los productos
    for (const [index, detalle] of detalleVentaList.value.entries()) {
        if (!detalle.id_producto || !detalle.cantidad || detalle.precio_venta == 0) {
            hasErrors = true;

            // Agregar errores si algún campo está vacío
            if (!detalle.id_producto) {
                notaVentaForm.errors[`detalle_${index}_id_producto`] = 'El nombre del producto es obligatorio.';
            }
            if (detalle.precio_venta == 0) {
                notaVentaForm.errors[`detalle_${index}_precio_venta`] = 'El producto no tiene precio de venta.';
            }
            if (!detalle.cantidad && detalle.cantidad !== 0) {
                // Si el campo está vacío (nulo o indefinido)
                notaVentaForm.errors[`detalle_${index}_cantidad`] = 'La cantidad es obligatoria.';
            } else if (detalle.cantidad <= 0) {
                // Si la cantidad es 0 o un número negativo
                notaVentaForm.errors[`detalle_${index}_cantidad`] = 'La cantidad debe ser mayor a 0.';
            } else {
                // Limpiar el error si no hay problemas
                delete notaVentaForm.errors[`detalle_${index}_cantidad`];
                // Limpiar el error si no hay problemas
                delete notaVentaForm.errors[`detalle_${index}_id_producto`];
                delete notaVentaForm.errors[`detalle_${index}_precio_venta`];
            }

        }
    }

    // Validar el método de pago
    if (!notaVentaForm.paymentmethod_id) {
        notaVentaForm.errors.paymentmethod_id = "Debe seleccionar un método de pago.";
        hasErrors = true;
    }
    // Validar campos del cliente (si corresponde)
    if (!clienteForm.nombre) {
        clienteForm.errors.nombre = "El nombre del cliente es obligatorio.";
        hasErrors = true;
    }
    if (!clienteForm.apellido) {
        clienteForm.errors.apellido = "El apellido del cliente es obligatorio.";
        hasErrors = true;
    }
    // 4. Si hay errores, detener el flujo
    if (hasErrors) {
        console.log(hasErrors);
        console.error("Errores en el formulario de nota de venta:");
        console.log(JSON.parse(JSON.stringify(notaVentaForm.errors)));


        console.error("Errores en el formulario del cliente:");

        console.log(JSON.parse(JSON.stringify(clienteForm.errors)));

        return;
    }

    try {

        // Crear cliente
        await clienteForm.post(route('clientes.store'), {
            onSuccess: (response) => {
                // Accede a los datos del cliente
                const cliente = response.props.cliente;

                if (cliente) {
                    const clienteId = cliente.id;
                    notaVentaForm.cliente_id = clienteId;

                    // Siempre creamos una nueva nota de venta
                    notaVentaForm.post(route('notaventas.store'), {
                        onSuccess: (responseNotaVenta) => {
                            const nuevaNotaVentaId = responseNotaVenta.props.notaventa.id;
                            // Crear detalles de venta con la nueva nota de venta
                            crearDetalleVenta(nuevaNotaVentaId);
                        }
                    });
                }
            }
        });
    } catch (error) {
        console.error("Error al crear cliente o nota de venta:", error);
    }
};

// Función para crear detalles de venta
const crearDetalleVenta = async (notaVentaId) => {
    try {
        for (const detalle of detalleVentaList.value) {
            detalle.id_nota_venta = notaVentaId;

            // Crear cada detalle de venta
            await useForm(detalle).post(route('detalleventas.store'));
        }
        console.log("Todos los detalles de venta fueron creados exitosamente.");
    } catch (error) {
        console.error("Error al crear detalles de venta:", error);
    }
};





// Método para capitalizar
const capitalizeWords = (input) => {
    return input.replace(/\b\w/g, (char) => char.toUpperCase());
};
</script>

<template>

    <Head title="Detalle venta" />
    <AuthenticatedLayout>
        <DefaultLayout>
            <DefaultCard cardTitle="Realizar ventas">
                <div class="p-6.5">
                    <!-- Formulario Cliente -->
                    <h2 class="mb-4 text-lg font-semibold">Datos del Cliente</h2>
                    <div class="mb-4.5">
                        <InputGroup v-model="clienteForm.nombre" label="Nombre" type="text"
                            placeholder="Ingrese el nombre"
                            @input="clienteForm.nombre = capitalizeWords(clienteForm.nombre)" />
                        <InputError :message="clienteForm.errors.nombre" class="mt-2" />
                    </div>
                    <div class="mb-4.5">
                        <InputGroup v-model="clienteForm.apellido" label="Apellido" type="text"
                            placeholder="Ingrese el apellido"
                            @input="clienteForm.apellido = capitalizeWords(clienteForm.apellido)" />
                        <InputError :message="clienteForm.errors.apellido" class="mt-2" />
                    </div>

                    <!-- Formulario Nota de Venta -->
                    <div class="mb-4.5">
                        <label class="mb-2.5 block text-black dark:text-white">Método de Pago</label>
                        <div class="relative z-20 bg-transparent dark:bg-form-input">
                            <select v-model="notaVentaForm.paymentmethod_id" id="paymentmethod_id"
                                class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                <option value="" disabled selected>Seleccionar método de pago</option>
                                <option v-for="item in paymentmethods" :key="item.id" :value="item.id">
                                    {{ item.metodo }}
                                </option>
                            </select>
                        </div>
                        <InputError :message="notaVentaForm.errors.paymentmethod_id" class="mt-2" />
                    </div>

                    <!-- Tabla de Detalles -->
                    <h2 class="mb-4 text-lg font-semibold">Detalles de Venta</h2>
                    <table class="table-auto w-full border-collapse border border-stroke mb-4.5">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700">
                                <th class="border border-stroke px-4 py-2 text-left">Producto</th>
                                <th class="border border-stroke px-4 py-2 text-left">Cantidad</th>
                                <th class="border border-stroke px-4 py-2 text-left">Precio de Venta</th>
                                <th class="border border-stroke px-4 py-2 text-left">Total</th>
                                <th class="border border-stroke px-4 py-2 text-left">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(detalle, index) in detalleVentaList" :key="index"
                                class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                <td class="border border-stroke px-4 py-2">
                                    <select v-model="detalle.id_producto" @change="updateDetalleVenta(detalle)"
                                        class="w-full rounded border py-2 px-3 dark:bg-gray-700 dark:text-white">
                                        <option value="" disabled selected>Seleccionar producto</option>
                                        <option v-for="product in products" :key="product.id" :value="product.id">
                                            {{ product.name }}
                                        </option>
                                    </select>
                                    <p v-if="notaVentaForm.errors[`detalle_${index}_id_producto`]" class="text-red-500">
                                        {{ notaVentaForm.errors[`detalle_${index}_id_producto`] }}
                                    </p>

                                </td>
                                <td class="border border-stroke px-4 py-2">
                                    <input type="number" v-model="detalle.cantidad" @input="updateDetalleVenta(detalle)"
                                        class="w-full rounded border py-2 px-3 dark:bg-gray-700 dark:text-white" />
                                    <p v-if="notaVentaForm.errors[`detalle_${index}_cantidad`]" class="text-red-500">
                                        {{ notaVentaForm.errors[`detalle_${index}_cantidad`] }}
                                    </p>
                                </td>
                                <td class="border border-stroke px-4 py-2">
                                    <input type="text" v-model="detalle.precio_venta" readonly
                                        class="w-full rounded border py-2 px-3 dark:bg-gray-700 dark:text-white" />
                                    <p v-if="notaVentaForm.errors[`detalle_${index}_precio_venta`]"
                                        class="text-red-500">
                                        {{ notaVentaForm.errors[`detalle_${index}_precio_venta`] }}
                                    </p>
                                </td>
                                <td class="border border-stroke px-4 py-2">
                                    <input type="text" v-model="detalle.total" readonly
                                        class="w-full rounded border py-2 px-3 dark:bg-gray-700 dark:text-white" />
                                </td>
                                <td class="border border-stroke px-4 py-2 text-center">
                                    <button @click.prevent="removeDetalleVenta(index)"
                                        class="bg-blue-700 hover:bg-red-800 text-white font-bold px-4 py-2 rounded">
                                        Eliminar
                                    </button>

                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Botón para añadir más productos -->
                    <button @click.prevent="addDetalleVenta"
                        class="bg-blue-500 text-white px-4 py-2 rounded mb-4">Añadir
                        Producto</button>

                    <!-- Total General -->
                    <div class="mb-4.5 text-right">
                        <h3 class="text-xl font-semibold">Total General: ${{ totalGeneral }}</h3>
                    </div>

                    <!-- Botón Guardar -->
                    <button @click.prevent="createClienteYNotaVenta"
                        class="bg-primary text-white px-6 py-3 rounded font-medium w-full">
                        Guardar Cliente y Nota de Venta
                    </button>

                </div>
            </DefaultCard>

        </DefaultLayout>


    </AuthenticatedLayout>
</template>
