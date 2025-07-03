<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import Pagination from "@/Components/Pagination.vue";
import InputGroup from '@/Components/Forms/InputGroup.vue'
import DefaultCard from '@/Components/Forms/DefaultCard.vue'
import { ref } from 'vue';
import SelectGroupTwo from '@/Components/Forms/SelectGroup/SelectGroupTwo.vue'
import InputError from '@/Components/InputError.vue';

import {Link, Head, useForm, usePage, router } from '@inertiajs/vue3';

defineProps({
    devolucion: {
        type: Object,
        required: true
    },
    suppliers: {
        type: Object,
        required: true
    },

    products: {
        type: Object,
        required: true
    },
    reasons: {
        type: Object,
        required: true
    }
});

let devolucion = usePage().props.devolucion.data;

const form = useForm({
    fecha_caducidad: devolucion.fecha_caducidad,
    cantidad: devolucion.cantidad,
    //image: null,
    product_id: devolucion.product.id,
    supplier_id: devolucion.supplier.id,
    reason_id: devolucion.reason.id,
})



const updateDevolucion = () => {

    router.post(route("devoluciones.update", devolucion.id), {
        _method: 'patch',
        fecha_caducidad: form.fecha_caducidad,
        cantidad: form.cantidad,
        // image: form.image,
        product_id: form.product_id,
        supplier_id: form.supplier_id,
        reason_id: form.reason_id,
    });

};

</script>

<template>

    <Head title="Editar Devolucion" />
    <AuthenticatedLayout>
        <DefaultLayout>
            <div class="grid grid-cols-1">
                <div class="flex flex-col ">
                    <Link
  :href="route('devoluciones.index')"
  class="inline-flex items-center rounded bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-300 mb-4"
>
  ← Volver al listado
</Link>
                    <!-- Contact Form Start -->
                    <DefaultCard cardTitle="Editar Devolucion">
                        <form @submit.prevent="updateDevolucion">
                            <div class="p-6.5">

                                <div>
                                    <InputGroup v-model="form.fecha_caducidad" label="Fecha de caducidad" type="date"
                                         customClasses="mb-4.5" />

                                    <InputError :message="form.errors.fecha_caducidad" class="mt-2" />
                                </div>
                                <div>
                                    <InputGroup v-model="form.cantidad" label="Cantidad" type="integer"
                                        placeholder="Introduzca una cantidad" customClasses="mb-4.5" />

                                    <InputError :message="form.errors.cantidad" class="mt-2" />
                                </div>


                                <!-- -->
                                <div class="mb-4.5">
                                    <label class="mb-2.5 block text-black dark:text-white"> Producto </label>

                                    <div class="relative z-20 bg-transparent dark:bg-form-input">
                                        <select v-model="form.product_id" id="product_id"
                                            class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                            :class="{
                                                ' text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300'
                                                    : form.errors.product_id
                                            }">
                                            <option value="" disabled>Seleccionar Producto</option>
                                            <option v-for="item in products.data" :key="item.id" :value="item.id">
                                                {{ item.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <InputError :message="form.errors.product_id" class="mt-2" />
                                </div>
                                <div class="mb-4.5">
                                    <label class="mb-2.5 block text-black dark:text-white"> Razon </label>

                                    <div class="relative z-20 bg-transparent dark:bg-form-input">
                                        <select v-model="form.reason_id" id="reason_id"
                                            class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                            :class="{
                                                ' text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300'
                                                    : form.errors.reason_id
                                            }">
                                            <option value="" disabled>Seleccionar razon</option>
                                            <option v-for="item in reasons.data" :key="item.id" :value="item.id">
                                                {{ item.descripcion }}
                                            </option>
                                        </select>
                                    </div>
                                    <InputError :message="form.errors.reason_id" class="mt-2" />
                                </div>

                                <div class="mb-4.5">
                                    <label class="mb-2.5 block text-black dark:text-white"> Proveedor </label>

                                    <div class="relative z-20 bg-transparent dark:bg-form-input">
                                        <select v-model="form.supplier_id" id="supplier_id"
                                            class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                            :class="{
                                                ' text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300'
                                                    : form.errors.supplier_id
                                            }">
                                            <option value="" disabled>Select supplier</option>
                                            <option v-for="item in suppliers.data" :key="item.id" :value="item.id">
                                                {{ item.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <InputError :message="form.errors.supplier_id" class="mt-2" />
                                </div>

                                <button type="submit"
                                    class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                                    Editar
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
