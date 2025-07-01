<template>

    <Head title="Editar Usuario" />
    <DefaultLayout>
        <div class="grid grid-cols-1">
            <div class="flex flex-col">
                <!-- Formulario de Edición de Usuario -->
                <DefaultCard cardTitle="Editar Usuario">
                    <form @submit.prevent="updateUser">
                        <div class="p-6.5">
                            <!-- Campo de Nombre -->
                            <div class="mb-4.5">
                                <label class="mb-2.5 block text-black dark:text-white">Nombre</label>
                                <p
                                    class="text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded py-2 px-4">
                                    {{ form.name }}
                                </p>
                            </div>

                            <!-- Campo de Correo Electrónico -->
                            <div class="mb-4.5">
                                <label class="mb-2.5 block text-black dark:text-white">Correo Electrónico</label>
                                <p
                                    class="text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded py-2 px-4">
                                    {{ form.email }}
                                </p>
                            </div>


                            <!-- Selector de Roles -->
                            <div class="mb-4.5">
                                <label class="mb-2.5 block text-black dark:text-white">Rol</label>
                                <div class="relative z-20 bg-transparent dark:bg-form-input">
                                    <select v-model="form.role_id" id="role_id"
                                        class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                        :class="{
                                            ' text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300': form.errors.role_id
                                        }">
                                        <option value="" disabled>Seleccionar rol</option>
                                        <option v-for="role in roles" :key="role.id" :value="role.id">
                                            {{ role.title }}
                                        </option>
                                    </select>
                                </div>
                                <InputError :message="form.errors.role_id" class="mt-2" />
                            </div>

                            <!-- Botón de Enviar -->
                            <button type="submit"
                                class="flex w-full justify-center rounded bg-primary p-3 font-medium text-white hover:bg-opacity-90">
                                Actualizar Usuario
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
import { useForm } from '@inertiajs/vue3';

// Verifica que los datos sean pasados correctamente
const props = defineProps({
    user: Object,
    roles: Array,
});

// Crea el formulario con los datos del usuario, incluyendo el role_id actual
const form = useForm({
    name: props.user.name,
    email: props.user.email,
    role_id: props.user.roles.length > 0 ? props.user.roles[0].id : null, // Asumiendo que el usuario tiene un solo rol
});

// Verifica el valor de form.role_id
console.log(form.role_id); // Verifica que el role_id esté correctamente configurado

// Función para enviar el formulario y actualizar el usuario
const updateUser = () => {
    form.put(route('users.update', props.user.id), {
        onFinish: () => form.reset(),
    });
};
</script>
