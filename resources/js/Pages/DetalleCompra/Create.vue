<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import Pagination from "@/Components/Pagination.vue";
import InputGroup from '@/Components/Forms/InputGroup.vue';
import DefaultCard from '@/Components/Forms/DefaultCard.vue';
import { ref, watch, computed } from 'vue';
import SelectGroupTwo from '@/Components/Forms/SelectGroup/SelectGroupTwo.vue';
import InputError from '@/Components/InputError.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';

// Props de entrada
const props = defineProps({
    proveedores: { type: Array, required: true },
    products: { type: Object, required: true }, // Cambiado a Object si tiene estructura con `data`
    paymentmethods: { type: Array, required: true },
});

// Datos iniciales de la página
const notacompras = usePage().props.notacompras;

// Estado del formulario principal
const form = useForm({
    fecha_caducidad: "",
    cantidad: "",
    precio_compra: "",
    total: "0.00",
    id_nota_compra: "",
    nombre_proveedor: "",
    id_producto: "",
});
const notaCompraForm = useForm({
    id_proveedor: "",
    id_metodo_pago: ""
});
// Formularios para cliente y nota de venta
const proveedorForm = useForm({
    name: "",
    nombre_empresa: "",
    phone: "",
});
// Lista de detalles de compra
const detalleCompraList = ref([{
    id_nota_compra: "",
    id_producto: "",
    fecha_caducidad: "",
    cantidad: "",
    precio_compra: "",
    total: 0,
}]);

// Watcher para calcular automáticamente el total general
watch(
    [() => detalleCompraList.value],
    () => {
        detalleCompraList.value.forEach(detalle => {
            detalle.total = (detalle.cantidad * detalle.precio_compra).toFixed(2);
        });
    },
    { deep: true }
);

// Computed para calcular el total general
const totalGeneral = computed(() => {
    return detalleCompraList.value.reduce((sum, detalle) => sum + parseFloat(detalle.total || 0), 0).toFixed(2);
});

// Métodos
const addDetalleCompra = () => {
    detalleCompraList.value.push({
        id_nota_compra: "",
        id_producto: "",
        fecha_caducidad: "",
        cantidad: "",
        precio_compra: "",
        total: 0,
    });
};

/*const removeDetalleCompra = (index) => {
    detalleCompraList.value.splice(index, 1);
};*/
// Método para eliminar un detalle de venta
const removeDetalleCompra = (index) => {
    //  detalleVentaList.value.splice(index, 1);
    if (detalleCompraList.value.length > 1) {
        detalleCompraList.value.splice(index, 1);
    } else {
        console.log("No se puede eliminar la última fila.");
    }
};

const updateDetalleCompra = (detalle) => {
    // Asegúrate de acceder correctamente a los datos del array
    const productList = Array.isArray(props.products.data) ? props.products.data : [];
    const selectedProduct = productList.find(product => product.id === detalle.id_producto);

    if (selectedProduct) {
        detalle.precio_compra = selectedProduct.precio_compra || 0;
        detalle.total = (detalle.cantidad * detalle.precio_compra).toFixed(2);
    } else {
        detalle.precio_compra = 0;
        detalle.total = 0;
    }
};
/*const createDetalleCompra = async () => {
    try {
        // Iteramos sobre cada detalle de compra para crear cada uno individualmente
        for (const detalle of detalleCompraList.value) {
            // Asegúrate de que cada detalle tiene la estructura correcta
            detalle.id_nota_compra = notacompras.id;

            // Usamos useForm para cada detalle y lo enviamos al backend
            await useForm(detalle).post(route('detallecompras.store'));
        }

        console.log("Todos los detalles de compra fueron creados exitosamente.");
    } catch (error) {
        console.error("Error al crear detalles de compra:", error);
    }
};*/
const createCompraCompleta = async () => {
    // Limpiar errores previos
    notaCompraForm.errors = {};
    proveedorForm.errors = {}; // Si también estás validando cliente
    // Bandera para saber si hay errores
    let hasErrors = false;
    console.log(hasErrors);
    // Validar los campos de todos los productos
    for (const [index, detalle] of detalleCompraList.value.entries()) {
        if (!detalle.id_producto || !detalle.fecha_caducidad || !detalle.precio_compra || !detalle.cantidad) {
            hasErrors = true;

            // Agregar errores si algún campo está vacío
            if (!detalle.id_producto) {
                notaCompraForm.errors[`detalle_${index}_id_producto`] = 'Debe seleccionar un producto.';
            }

            if (!detalle.fecha_caducidad) {
                // Si el campo está vacío (nulo o indefinido)
                notaCompraForm.errors[`detalle_${index}_fecha_caducidad`] = 'La fecha de caducidad es obligatoria.';
            }
            if (!detalle.precio_compra && detalle.precio_compra !== 0) {
                notaCompraForm.errors[`detalle_${index}_precio_compra`] = 'El precio de compra es obligatorio.';
            } else if (detalle.precio_compra <= 0) {
                // Si la cantidad es 0 o un número negativo
                notaCompraForm.errors[`detalle_${index}_precio_compra`] = 'El precio de compra debe ser mayor a 0.';
            }/* else {
                // Limpiar el error si no hay problemas
                delete notaCompraForm.errors[`detalle_${index}_cantidad`];
                // Limpiar el error si no hay problemas
                delete notaCompraForm.errors[`detalle_${index}_id_producto`];
                delete notaCompraForm.errors[`detalle_${index}_precio_venta`];
            }*/

            if (!detalle.cantidad && detalle.cantidad !== 0) {
                // Si el campo está vacío (nulo o indefinido)
                notaCompraForm.errors[`detalle_${index}_cantidad`] = 'La cantidad es obligatoria.';
            } else if (detalle.cantidad <= 0) {
                // Si la cantidad es 0 o un número negativo
                notaCompraForm.errors[`detalle_${index}_cantidad`] = 'La cantidad debe ser mayor a 0.';
            }/* else {
                // Limpiar el error si no hay problemas
                delete notaCompraForm.errors[`detalle_${index}_cantidad`];
                // Limpiar el error si no hay problemas
                delete notaCompraForm.errors[`detalle_${index}_id_producto`];
                delete notaCompraForm.errors[`detalle_${index}_precio_venta`];
            }*/

        }
    }

    // Validar el método de pago
    if (!notaCompraForm.id_metodo_pago) {
        notaCompraForm.errors.id_metodo_pago = "Debe seleccionar un método de pago.";
        hasErrors = true;
    }
    // Validar campos del cliente (si corresponde)
    if (!proveedorForm.name) {
        proveedorForm.errors.name = "El nombre del proveedor es obligatorio.";
        hasErrors = true;
    }
    if (!proveedorForm.nombre_empresa) {
        proveedorForm.errors.nombre_empresa = "El nombre de la empresa es obligatorio.";
        hasErrors = true;
    }
    if (!proveedorForm.phone) {
        proveedorForm.errors.phone = "El celular es obligatorio.";
        hasErrors = true;
    }
    // 4. Si hay errores, detener el flujo
    if (hasErrors) {
        console.log(hasErrors);
        console.error("Errores en el formulario de nota de venta:");
        console.log(JSON.parse(JSON.stringify(notaCompraForm.errors)));


        console.error("Errores en el formulario del cliente:");

        console.log(JSON.parse(JSON.stringify(proveedorForm.errors)));

        return;
    }
    try {
        // Paso 1: Registrar al proveedor
        await proveedorForm.post(route('suppliers.store'), {
            onSuccess: (responseProveedor) => {
                // Obtén el ID del proveedor registrado
                const proveedorId = responseProveedor.props.supplier.id;

                if (proveedorId) {
                    // Paso 2: Crear la nota de compra asociada al proveedor
                    notaCompraForm.id_proveedor = proveedorId; // Asigna el ID del proveedor al formulario de nota de compra
                    notaCompraForm.post(route('notacompras.store'), {
                        onSuccess: (responseNotaCompra) => {
                            const notaCompraId = responseNotaCompra.props.notacompra.id; // Obtén el ID de la nota de compra creada

                            // Paso 3: Crear los detalles de compra asociados a la nota de compra
                            crearDetalleCompra(notaCompraId);
                        },
                        onError: (error) => {
                            console.error("Error al crear la nota de compra:", error);
                        }
                    });
                }
            },
            onError: (error) => {
                console.error("Error al crear proveedor:", error);
            }
        });
    } catch (error) {
        console.error("Error al registrar la compra completa:", error);
    }
};

// Función para crear detalles de compra
const crearDetalleCompra = async (notaCompraId) => {
    try {
        // Paso 4: Crear los detalles de compra asociados a la nota de compra
        for (const detalle of detalleCompraList.value) {
            const detalleForm = useForm({
                ...detalle,
                id_nota_compra: notaCompraId, // Asigna el ID de la nota de compra a cada detalle
            });

            // Enviamos cada detalle de compra
            await detalleForm.post(route('detallecompras.store'));
        }
        console.log("Todos los detalles de compra fueron creados exitosamente.");
    } catch (error) {
        console.error("Error al crear los detalles de compra:", error);
    }
};


// Método para capitalizar
const capitalizeWords = (input) => {
    return input.replace(/\b\w/g, (char) => char.toUpperCase());
};

</script>
<template>

    <Head title="Detalle Compra" />
    <AuthenticatedLayout>
        <DefaultLayout>
            <div class="grid grid-cols-1">
                <div class="flex flex-col">


                    <!-- Formulario -->
                    <DefaultCard cardTitle="Realizar compra de productos">
                        <form @submit.prevent="createCompraCompleta">
                            <div class="p-6.5">
                                <!-- Formulario Proveedor -->
                                <h2 class="mb-4 text-lg font-semibold">Datos del Proveedor</h2>
                                <div class="mb-4.5">
                                    <InputGroup v-model="proveedorForm.name" label="Nombre" type="text"
                                        placeholder="Ingrese el nombre"
                                        @input="proveedorForm.name = capitalizeWords(proveedorForm.name)" />
                                    <InputError :message="proveedorForm.errors.name" class="mt-2" />
                                </div>
                                <div class="mb-4.5">
                                    <InputGroup v-model="proveedorForm.nombre_empresa" label="Nombre de la empresa"
                                        type="text" placeholder="Ingrese el nombre de la empresa"
                                        @input="proveedorForm.nombre_empresa = capitalizeWords(proveedorForm.nombre_empresa)" />
                                    <InputError :message="proveedorForm.errors.nombre_empresa" class="mt-2" />
                                </div>
                                <div class="mb-4.5">
                                    <InputGroup v-model="proveedorForm.phone" label="Celular" type="text"
                                        placeholder="Ingrese el celular"
                                        @input="proveedorForm.phone = capitalizeWords(proveedorForm.phone)" />
                                    <InputError :message="proveedorForm.errors.phone" class="mt-2" />
                                </div>
                                <!-- Formulario Nota de Venta -->

                                <div class="mb-4.5">
                                    <label class="mb-2.5 block text-black dark:text-white">Método de Pago</label>
                                    <div class="relative z-20 bg-transparent dark:bg-form-input">
                                        <select v-model="notaCompraForm.id_metodo_pago" id="id_metodo_pago"
                                            class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                            <option value="" disabled selected>Seleccionar método de pago</option>
                                            <option v-for="item in paymentmethods" :key="item.id" :value="item.id">
                                                {{ item.metodo }}
                                            </option>
                                        </select>
                                        <InputError :message="notaCompraForm.errors.id_metodo_pago" class="mt-2" />
                                    </div>

                                </div>
                                <h2 class="mb-4 text-lg font-semibold">Detalles de Compra</h2>

                                <table class="table-auto w-full border-collapse border border-stroke mb-4.5">
                                    <thead>
                                        <tr class="bg-gray-100 dark:bg-gray-700">
                                            <th class="border border-stroke px-4 py-2 text-left">Producto</th>
                                            <th class="border border-stroke px-4 py-2 text-left">Fecha caducidad</th>
                                            <th class="border border-stroke px-4 py-2 text-left">Cantidad</th>
                                            <th class="border border-stroke px-4 py-2 text-left">Precio de Compra</th>
                                            <th class="border border-stroke px-4 py-2 text-left">Total</th>
                                            <th class="border border-stroke px-4 py-2 text-center">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(detalle, index) in detalleCompraList" :key="index">
                                            <td class="border border-stroke px-4 py-2">
                                                <select v-model="detalle.id_producto"
                                                    @change="updateDetalleCompra(detalle)"
                                                    class="w-full rounded border py-2 px-3 dark:bg-gray-700 dark:text-white">
                                                    <option value="" disabled>Seleccionar producto</option>
                                                    <option v-for="product in products" :key="product.id"
                                                        :value="product.id">
                                                        {{ product.name }}
                                                    </option>
                                                </select>
                                                <p v-if="notaCompraForm.errors[`detalle_${index}_id_producto`]"
                                                    class="text-red-500">
                                                    {{ notaCompraForm.errors[`detalle_${index}_id_producto`] }}
                                                </p>
                                            </td>
                                            <td class="border border-stroke px-4 py-2">
                                                <input type="date" v-model="detalle.fecha_caducidad"
                                                    class="w-full rounded border py-2 px-3 dark:bg-gray-700 dark:text-white" />
                                                <p v-if="notaCompraForm.errors[`detalle_${index}_fecha_caducidad`]"
                                                    class="text-red-500">
                                                    {{ notaCompraForm.errors[`detalle_${index}_fecha_caducidad`] }}
                                                </p>
                                            </td>
                                            <td class="border border-stroke px-4 py-2">
                                                <input type="number" v-model="detalle.cantidad"
                                                    @input="updateDetalleCompra(detalle)"
                                                    class="w-full rounded border py-2 px-3 dark:bg-gray-700 dark:text-white" />
                                                <p v-if="notaCompraForm.errors[`detalle_${index}_cantidad`]"
                                                    class="text-red-500">
                                                    {{ notaCompraForm.errors[`detalle_${index}_cantidad`] }}
                                                </p>
                                            </td>
                                            <td class="border border-stroke px-4 py-2">
                                                <input type="text" v-model="detalle.precio_compra"
                                                    class="w-full rounded border py-2 px-3 dark:bg-gray-700 dark:text-white" />
                                                <p v-if="notaCompraForm.errors[`detalle_${index}_precio_compra`]"
                                                    class="text-red-500">
                                                    {{ notaCompraForm.errors[`detalle_${index}_precio_compra`] }}
                                                </p>
                                            </td>
                                            <td class="border border-stroke px-4 py-2">
                                                <input type="text" v-model="detalle.total" readonly
                                                    class="w-full rounded border py-2 px-3 dark:bg-gray-700 dark:text-white" />
                                            </td>
                                            <td class="border border-stroke px-4 py-2 text-center">
                                                <button @click.prevent="removeDetalleCompra(index)"
                                                    class="bg-blue-700 hover:bg-red-800 text-white font-bold px-4 py-2 rounded">
                                                    Eliminar
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!-- Botón añadir -->
                                <button @click.prevent="addDetalleCompra"
                                    class="bg-blue-500 text-white px-4 py-2 rounded mb-4">
                                    Añadir Producto
                                </button>

                                <!-- Total general -->
                                <div class="mb-4.5 text-right">
                                    <h3 class="text-xl font-semibold">Total General: ${{ totalGeneral }}</h3>
                                </div>

                                <!-- Botón guardar -->
                                <button type="submit"
                                    class="w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                                    Guardar
                                </button>
                            </div>
                        </form>
                    </DefaultCard>
                </div>
            </div>
        </DefaultLayout>
    </AuthenticatedLayout>
</template>