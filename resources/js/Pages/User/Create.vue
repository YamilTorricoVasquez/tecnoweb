<template>

    <Head title="Sign Up" />
    <DefaultLayout>
        <div class="grid grid-cols-1">
            <div class="flex flex-col">
                <!-- Formulario de Registro -->
                <DefaultCard cardTitle="Registrar Nuevo Usuario">
                    <form @submit.prevent="submit">
                        <div class="p-6.5">
                            <!-- Campo de Nombre -->
                            <div class="mb-4.5">
                                <InputGroup v-model="form.name" label="Nombre" type="text"
                                    placeholder="Ingrese su nombre completo" />
                                <InputError :message="form.errors.name" class="mt-2" />
                            </div>

                            <!-- Campo de Correo Electrónico -->
                            <div class="mb-4.5">
                                <InputGroup v-model="form.email" label="Correo Electrónico" type="email"
                                    placeholder="Ingrese su correo electrónico" />
                                <InputError :message="form.errors.email" class="mt-2" />
                            </div>

                            <!-- Campo de Contraseña -->
                            <div class="mb-4.5">
                                <InputGroup v-model="form.password" label="Contraseña" type="password"
                                    placeholder="Ingrese su contraseña" />
                                <InputError :message="form.errors.password" class="mt-2" />
                            </div>

                            <!-- Campo de Confirmación de Contraseña -->
                            <div class="mb-4.5">
                                <InputGroup v-model="form.password_confirmation" label="Confirmar Contraseña"
                                    type="password" placeholder="Confirme su contraseña" />
                                <InputError :message="form.errors.password_confirmation" class="mt-2" />
                            </div>
                            <!-- Campo de selección de rol -->
                            <div class="mb-4.5">
                                <label class="mb-2.5 block text-black dark:text-white"> Rol </label>

                                <div class="relative z-20 bg-transparent dark:bg-form-input">
                                    <select v-model="form.role_id" id="role_id"
                                        class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                        :class="{
                                            ' text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300'
                                                : form.errors.role_id
                                        }">
                                        <option value="" disabled selected>Seleccionar rol</option>
                                        <option v-for="item in roles" :key="item.id" :value="item.id">
                                            {{ item.title }}
                                        </option>
                                    </select>
                                </div>
                                <InputError :message="form.errors.role_id" class="mt-2" />
                            </div>

                            <!-- Botón de Enviar -->
                            <button type="submit"
                                class="flex w-full justify-center rounded bg-primary p-3 font-medium text-white hover:bg-opacity-90">
                                Crear Cuenta
                            </button>
                        </div>
                    </form>
                </DefaultCard>
            </div>
        </div>
    </DefaultLayout>
</template>

<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import InputGroup from '@/Components/Forms/InputGroup.vue';
import DefaultCard from '@/Components/Forms/DefaultCard.vue';
import InputError from '@/Components/InputError.vue';
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role_id: '',
});
defineProps({
    roles: {
        type: Object,
        required: true
    },
});
const submit = () => {
    form.post(route('users.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>
