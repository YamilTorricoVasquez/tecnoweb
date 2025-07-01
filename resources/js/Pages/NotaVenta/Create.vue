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
    clientes: {
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
     },*/

});

let sections = ref({});

const form = useForm({
    // fecha: "",
    // total: "",
    cliente_id: "",
    paymentmethod_id: "",
    //  user_id: "",
    // supplier_id: "",

})




const createNotaVenta = () => {
    form.post(route('notaventas.store'));
}

</script>

<template>

    <Head title="Nota venta" />
    <AuthenticatedLayout>
        <DefaultLayout>
            <div class="grid grid-cols-1">
                <div class="flex flex-col ">
                    <!-- Contact Form Start -->
                    <DefaultCard cardTitle="Agregar Nota de venta">
                        <form @submit.prevent="createNotaVenta">
                            <div class="p-6.5">




                                <div class="mb-4.5">
                                    <label class="mb-2.5 block text-black dark:text-white"> Cliente </label>

                                    <div class="relative z-20 bg-transparent dark:bg-form-input">
                                        <select v-model="form.cliente_id" id="cliente_id"
                                            class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                            :class="{
                                                ' text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300'
                                                    : form.errors.cliente_id
                                            }">
                                            <option value="" disabled selected>Seleccionar cliente</option>
                                            <option v-for="item in clientes.data" :key="item.id" :value="item.id">
                                                {{ item.nombre + " " + item.apellido }}
                                            </option>
                                        </select>
                                    </div>
                                    <InputError :message="form.errors.cliente_id" class="mt-2" />
                                </div>

                                <div class="mb-4.5">
                                    <label class="mb-2.5 block text-black dark:text-white"> Metodo de pago </label>

                                    <div class="relative z-20 bg-transparent dark:bg-form-input">
                                        <select v-model="form.paymentmethod_id" id="paymentmethod_id"
                                            class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                            :class="{
                                                ' text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300'
                                                    : form.errors.paymentmethod_id
                                            }">
                                            <option value="" disabled selected>Seleccionar metodo de pago</option>
                                            <option v-for="item in paymentmethods.data" :key="item.id" :value="item.id">
                                                {{ item.metodo }}
                                            </option>
                                        </select>
                                    </div>
                                    <InputError :message="form.errors.paymentmethod_id" class="mt-2" />
                                </div>
                                <button type="submit"
                                    class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
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
