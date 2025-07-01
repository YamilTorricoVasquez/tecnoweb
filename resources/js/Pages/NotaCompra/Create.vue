<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import Pagination from "@/Components/Pagination.vue";
import InputGroup from '@/Components/Forms/InputGroup.vue'
import DefaultCard from '@/Components/Forms/DefaultCard.vue'
import { ref } from 'vue';
import SelectGroupTwo from '@/Components/Forms/SelectGroup/SelectGroupTwo.vue'
import InputError from '@/Components/InputError.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'; // Verifica la ruta

import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    suppliers: {
        type: Object,
        required: true
    },
    paymentmethods: {
        type: Object,
        required: true
    },
    /* reasons: {
         type: Object,
         required: true
     },
      users: {
         type: Object,
         required: true
     }*/
});

let sections = ref({});

const form = useForm({
    // fecha: "",
    // total: "",
    id_proveedor: "",
    id_metodo_pago: "",
    //  user_id: "",
    // supplier_id: "",

})


const handleFileUpload = (event) => {
    form.image = event.target.files[0];
}

const createNotaCompra = () => {
    form.post(route('notacompras.store'));
}

</script>

<template>

    <Head title="Nota compra" />
    <AuthenticatedLayout>
        <DefaultLayout>
            <div class="grid grid-cols-1">
                <div class="flex flex-col ">
                    <!-- Contact Form Start -->
                    <DefaultCard cardTitle="Agregar Nota de compra">
                        <form @submit.prevent="createNotaCompra">
                            <div class="p-6.5">




                                <div class="mb-4.5">
                                    <label class="mb-2.5 block text-black dark:text-white"> Proveedor </label>

                                    <div class="relative z-20 bg-transparent dark:bg-form-input">
                                        <select v-model="form.id_proveedor" id="id_proveedor"
                                            class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                            :class="{
                                                ' text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300'
                                                    : form.errors.id_proveedor
                                            }">
                                            <option value="" disabled selected>Seleccionar proveedor</option>
                                            <option v-for="item in suppliers.data" :key="item.id" :value="item.id">
                                                {{ item.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <InputError :message="form.errors.id_proveedor" class="mt-2" />
                                </div>
                                <!--<div class="mb-4.5">
                                    <label class="mb-2.5 block text-black dark:text-white"> Usuario </label>
                                    <div class="relative z-20 bg-transparent dark:bg-form-input">
                                        <select v-model="form.user_id" id="product_id"
                                            class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                            :class="{
                                                ' text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300'
                                                    : form.errors.user_id
                                            }">
                                            <option value="" disabled selected>Seleccionar usuario</option>
                                            <option :value="users[0]">{{ users[0] }}</option>
                                            
                                        </select>
                                    </div>
                                    <InputError :message="form.errors.user_id" class="mt-2" />
                                </div>


                                <div class="mb-4.5">
                                    <label class="mb-2.5 block text-black dark:text-white"> Producto </label>

                                    <div class="relative z-20 bg-transparent dark:bg-form-input">
                                        <select v-model="form.product_id" id="product_id"
                                            class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                            :class="{
                                                ' text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300'
                                                    : form.errors.product_id
                                            }">
                                            <option value="" disabled selected>Seleccionar producto</option>
                                            <option v-for="item in products.data" :key="item.id" :value="item.id">
                                                {{ item.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <InputError :message="form.errors.product_id" class="mt-2" />
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
                                            <option value="" disabled selected>Seleccionar proveedor</option>
                                            <option v-for="item in suppliers.data" :key="item.id" :value="item.id">
                                                {{ item.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <InputError :message="form.errors.supplier_id" class="mt-2" />
                                </div>-->
                                <div class="mb-4.5">
                                    <label class="mb-2.5 block text-black dark:text-white"> Metodo de pago </label>

                                    <div class="relative z-20 bg-transparent dark:bg-form-input">
                                        <select v-model="form.id_metodo_pago" id="id_metodo_pago"
                                            class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                            :class="{
                                                ' text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300'
                                                    : form.errors.reason_id
                                            }">
                                            <option value="" disabled selected>Seleccionar metodo de pago</option>
                                            <option v-for="item in paymentmethods.data" :key="item.id" :value="item.id">
                                                {{ item.metodo }}
                                            </option>
                                        </select>
                                    </div>
                                    <InputError :message="form.errors.reason_id" class="mt-2" />
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
