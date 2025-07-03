<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const visitas = ref(0);
const medicamentos = ref([]);
const pagination = ref({
    current_page: 1,
    last_page: 1,
});

const fetchMedicamentos = async (page = 1) => {
    try {
        const response = await axios.get(`/medicamentos?page=${page}`);
        medicamentos.value = response.data.data;
        pagination.value = {
            current_page: response.data.current_page,
            last_page: response.data.last_page,
        };
    } catch (e) {
        medicamentos.value = [];
        pagination.value = { current_page: 1, last_page: 1 };
    }
};

onMounted(async () => {
    try {
        const response = await axios.post('/visitas');
        visitas.value = response.data.visitas;
    } catch (e) {
        visitas.value = 'Error';
    }
    fetchMedicamentos();
});

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: { type: String, required: true },
    phpVersion: { type: String, required: true },
});
</script>

<template>
    <Head title="Farmacia Alicia - Tu Salud, Nuestra Prioridad" />
    <div class="bg-green-50 min-h-screen flex flex-col">
        <header class="bg-green-700 py-8 text-center text-white shadow-lg">
            <div class="flex flex-col items-center justify-center">
                <img src="https://cdn-icons-png.flaticon.com/512/616/616494.png" alt="Logo Farmacia Alicia" class="w-24 h-24 mb-3 rounded-full shadow bg-white p-2" />
                <h1 class="text-5xl font-extrabold mb-2 tracking-wide">Farmacia Alicia</h1>
                <p class="text-xl font-light mb-4">Profesionales en medicamentos y bienestar familiar</p>
                <nav v-if="canLogin" class="mt-2">
                    <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                        class="rounded-md px-4 py-2 bg-white text-green-700 font-semibold shadow hover:bg-green-100 transition">
                        Dashboard
                    </Link>
                    <template v-else>
                        <Link :href="route('login')"
                            class="rounded-md px-4 py-2 bg-white text-green-700 font-semibold shadow hover:bg-green-100 transition">
                            Iniciar sesión
                        </Link>
                    </template>
                </nav>
            </div>
        </header>

        <main class="flex-1 w-full max-w-4xl mx-auto px-4 py-10">
            <section class="mb-10 flex flex-col md:flex-row items-center gap-8">
                <img src="https://cdn-icons-png.flaticon.com/512/3209/3209265.png" alt="Mostrador Farmacia" class="w-40 md:w-56 rounded-xl shadow-lg bg-white p-2" />
                <div>
                    <h2 class="text-3xl font-bold text-green-800 mb-3">Bienvenido a Farmacia Alicia</h2>
                    <p class="text-gray-700 text-lg mb-2">
                        En <span class="font-semibold text-green-700">Farmacia Alicia</span> nos dedicamos a cuidar de ti y de tu familia con un equipo de farmacéuticos certificados, atención personalizada y medicamentos de la más alta calidad.
                    </p>
                    <p class="text-gray-600">
                        Confía en nosotros para el suministro seguro de tus tratamientos, productos de cuidado personal y servicios de prevención. ¡Tu salud es nuestra prioridad!
                    </p>
                </div>
            </section>

            <section class="mb-10 bg-white rounded-lg shadow p-6">
                <h3 class="text-2xl font-semibold mb-4 text-green-700">Nuestros Servicios Profesionales</h3>
                <ul class="list-disc list-inside text-gray-700 text-lg space-y-2">
                    <li>Dispensación de medicamentos con y sin receta</li>
                    <li>Asesoría farmacéutica profesional y seguimiento de tratamientos</li>
                    <li>Control de presión arterial y glucosa</li>
                    <li>Productos de cuidado personal, higiene y bienestar</li>
                    <li>Atención a pacientes crónicos y adultos mayores</li>
                    <li>Entrega a domicilio y pedidos en línea</li>
                </ul>
            </section>

            <section class="mb-10 bg-white rounded-lg shadow p-6">
                <h3 class="text-2xl font-semibold mb-4 text-green-700">Medicamentos Disponibles</h3>
                <div v-if="medicamentos.length > 0">
                    <table class="min-w-full text-left text-gray-700">
                        <thead>
                            <tr>
                                <th class="py-2 px-4">Nombre</th>
                                <th class="py-2 px-4">Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="med in medicamentos" :key="med.id">
                                <td class="py-2 px-4">{{ med.name }}</td>
                                <td class="py-2 px-4">{{ med.descripcion }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- Controles de paginación -->
                    <div class="flex justify-center mt-4 space-x-2" v-if="pagination.last_page > 1">
                        <button
                            class="px-3 py-1 bg-green-200 rounded hover:bg-green-300"
                            :disabled="pagination.current_page === 1"
                            @click="fetchMedicamentos(pagination.current_page - 1)"
                        >
                            Anterior
                        </button>
                        <span class="px-3 py-1 font-bold">
                            Página {{ pagination.current_page }} de {{ pagination.last_page }}
                        </span>
                        <button
                            class="px-3 py-1 bg-green-200 rounded hover:bg-green-300"
                            :disabled="pagination.current_page === pagination.last_page"
                            @click="fetchMedicamentos(pagination.current_page + 1)"
                        >
                            Siguiente
                        </button>
                    </div>
                </div>
                <div v-else class="text-gray-500">No hay medicamentos registrados.</div>
            </section>

            <section class="bg-green-100 rounded-lg shadow p-6">
                <h3 class="text-2xl font-semibold mb-3 text-green-800">Contáctanos</h3>
                <p class="text-gray-700 text-lg mb-1">
                    <span class="font-semibold">Dirección:</span> Calle Principal #123, Ciudad
                </p>
                <p class="text-gray-700 text-lg mb-1">
                    <span class="font-semibold">Teléfono:</span> (555) 123-4567
                </p>
                <p class="text-gray-700 text-lg">
                    <span class="font-semibold">Correo:</span> contacto@farmaciaalicia.com
                </p>
                <div class="mt-4">
                    <a href="https://wa.me/5551234567" target="_blank"
                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded shadow hover:bg-green-700 transition">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M20.52 3.48A11.93 11.93 0 0 0 12 0C5.37 0 0 5.37 0 12c0 2.11.55 4.16 1.6 5.97L0 24l6.22-1.62A11.93 11.93 0 0 0 12 24c6.63 0 12-5.37 12-12 0-3.19-1.24-6.19-3.48-8.52zM12 22c-1.85 0-3.67-.5-5.25-1.44l-.38-.22-3.69.96.99-3.59-.25-.37A9.93 9.93 0 0 1 2 12c0-5.52 4.48-10 10-10s10 4.48 10 10-4.48 10-10 10zm5.2-7.8c-.28-.14-1.65-.81-1.9-.9-.25-.09-.43-.14-.61.14-.18.28-.7.9-.86 1.08-.16.18-.32.2-.6.07-.28-.14-1.18-.43-2.25-1.38-.83-.74-1.39-1.65-1.55-1.93-.16-.28-.02-.43.12-.57.13-.13.28-.34.42-.51.14-.17.18-.29.28-.48.09-.19.05-.36-.02-.5-.07-.14-.61-1.47-.84-2.01-.22-.53-.45-.46-.61-.47-.16-.01-.36-.01-.56-.01-.19 0-.5.07-.76.34-.26.27-1 1-.98 2.44.02 1.44 1.03 2.84 1.18 3.04.15.2 2.03 3.1 4.93 4.23.69.3 1.23.48 1.65.61.69.22 1.32.19 1.82.12.56-.08 1.65-.67 1.88-1.32.23-.65.23-1.21.16-1.32-.07-.11-.25-.18-.53-.32z"/></svg>
                        Contáctanos por WhatsApp
                    </a>
                </div>
            </section>
        </main>

        <footer class="w-full py-4 text-center text-sm text-gray-600 bg-green-100 font-bold">
            Visitas: {{ visitas }} | &copy; 2025 Farmacia Alicia
        </footer>
    </div>
</template>