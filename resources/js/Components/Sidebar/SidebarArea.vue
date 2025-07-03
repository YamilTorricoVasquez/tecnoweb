<script setup lang="ts">
import { useSidebarStore } from '@/stores/sidebar'
import { onClickOutside } from '@vueuse/core'
import { ref } from 'vue'
import SidebarItem from './SidebarItem.vue'
import { usePage } from '@inertiajs/vue3'
const page = usePage();
const target = ref(null)

const sidebarStore = useSidebarStore()

onClickOutside(target, () => {
  sidebarStore.isSidebarOpen = false
})

const menuGroups = ref([
  {
    name: 'Dashboard',
    menuItems: [
      {
        icon: `<svg
                  class="fill-current"
                  width="18"
                  height="18"
                  viewBox="0 0 18 18"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M6.10322 0.956299H2.53135C1.5751 0.956299 0.787598 1.7438 0.787598 2.70005V6.27192C0.787598 7.22817 1.5751 8.01567 2.53135 8.01567H6.10322C7.05947 8.01567 7.84697 7.22817 7.84697 6.27192V2.72817C7.8751 1.7438 7.0876 0.956299 6.10322 0.956299ZM6.60947 6.30005C6.60947 6.5813 6.38447 6.8063 6.10322 6.8063H2.53135C2.2501 6.8063 2.0251 6.5813 2.0251 6.30005V2.72817C2.0251 2.44692 2.2501 2.22192 2.53135 2.22192H6.10322C6.38447 2.22192 6.60947 2.44692 6.60947 2.72817V6.30005Z"
                    fill=""
                  />
                  <path
                    d="M15.4689 0.956299H11.8971C10.9408 0.956299 10.1533 1.7438 10.1533 2.70005V6.27192C10.1533 7.22817 10.9408 8.01567 11.8971 8.01567H15.4689C16.4252 8.01567 17.2127 7.22817 17.2127 6.27192V2.72817C17.2127 1.7438 16.4252 0.956299 15.4689 0.956299ZM15.9752 6.30005C15.9752 6.5813 15.7502 6.8063 15.4689 6.8063H11.8971C11.6158 6.8063 11.3908 6.5813 11.3908 6.30005V2.72817C11.3908 2.44692 11.6158 2.22192 11.8971 2.22192H15.4689C15.7502 2.22192 15.9752 2.44692 15.9752 2.72817V6.30005Z"
                    fill=""
                  />
                  <path
                    d="M6.10322 9.92822H2.53135C1.5751 9.92822 0.787598 10.7157 0.787598 11.672V15.2438C0.787598 16.2001 1.5751 16.9876 2.53135 16.9876H6.10322C7.05947 16.9876 7.84697 16.2001 7.84697 15.2438V11.7001C7.8751 10.7157 7.0876 9.92822 6.10322 9.92822ZM6.60947 15.272C6.60947 15.5532 6.38447 15.7782 6.10322 15.7782H2.53135C2.2501 15.7782 2.0251 15.5532 2.0251 15.272V11.7001C2.0251 11.4188 2.2501 11.1938 2.53135 11.1938H6.10322C6.38447 11.1938 6.60947 11.4188 6.60947 11.7001V15.272Z"
                    fill=""
                  />
                  <path
                    d="M15.4689 9.92822H11.8971C10.9408 9.92822 10.1533 10.7157 10.1533 11.672V15.2438C10.1533 16.2001 10.9408 16.9876 11.8971 16.9876H15.4689C16.4252 16.9876 17.2127 16.2001 17.2127 15.2438V11.7001C17.2127 10.7157 16.4252 9.92822 15.4689 9.92822ZM15.9752 15.272C15.9752 15.5532 15.7502 15.7782 15.4689 15.7782H11.8971C11.6158 15.7782 11.3908 15.5532 11.3908 15.272V11.7001C11.3908 11.4188 11.6158 11.1938 11.8971 11.1938H15.4689C15.7502 11.1938 15.9752 11.4188 15.9752 11.7001V15.272Z"
                    fill=""
                  />
                </svg>`,
        label: 'Dashboard',
        route: route('dashboard'),
        //route: '/dashboard',
      }
    ]
  },
  {
    name: 'Farmacia',
    menuItems: [
      {
        icon: `<svg
  class="fill-current"
  width="18"
  height="18"
  viewBox="0 0 24 24"
  xmlns="http://www.w3.org/2000/svg"
>
  <path
    d="M17 2H7C5.9 2 5 2.9 5 4V6C5 7.1 5.9 8 7 8H17C18.1 8 19 7.1 19 6V4C19 2.9 18.1 2 17 2ZM17 6H7V4H17V6ZM20 10H4C3.45 10 3 10.45 3 11V20C3 21.1 3.9 22 5 22H19C20.1 22 21 21.1 21 20V11C21 10.45 20.55 10 20 10ZM13 17H11V19H9V17H7V15H9V13H11V15H13V17Z"
    fill="currentColor"
  />
</svg>
`,
        label: 'Medicamentos',
        //route: '/products'
        route: route('products.index'),
        permission: 'ver_medicamentos',
      },
      {
        icon: `<svg
  class="fill-current"
  width="18"
  height="18"
  viewBox="0 0 24 24"
  xmlns="http://www.w3.org/2000/svg"
>
  <path
    d="M4 4H10V10H4V4ZM14 4H20V10H14V4ZM4 14H10V20H4V14ZM14 14H20V20H14V14Z"
    fill="currentColor"
  />
</svg>
`,
        label: 'Categorias',
        //route: '/categories',
        route:  route('categories.index'),
      },
      {
        icon: `<svg
  class="fill-current"
  width="18"
  height="18"
  viewBox="0 0 24 24"
  xmlns="http://www.w3.org/2000/svg"
>
  <path
    d="M21 8H3C1.9 8 1 8.9 1 10V19C1 20.1 1.9 21 3 21H21C22.1 21 23 20.1 23 19V10C23 8.9 22.1 8 21 8ZM21 19H3V10H21V19ZM12 12L16 16H13V20H11V16H8L12 12ZM21 4H17V2H7V4H3V6H21V4Z"
    fill="currentColor"
  />
</svg>
`,
        label: 'Proveedores',
        //route: '/suppliers',
        route:  route('suppliers.index'),
      },
      {
        icon: `<svg
    class="fill-current"
    width="18"
    height="18"
    viewBox="0 0 24 24"
    xmlns="http://www.w3.org/2000/svg"
  >
    <path
      d="M12 12C14.76 12 17 9.76 17 7C17 4.24 14.76 2 12 2C9.24 2 7 4.24 7 7C7 9.76 9.24 12 12 12ZM12 14C9.33 14 4 15.34 4 18V20C4 20.55 4.45 21 5 21H19C19.55 21 20 20.55 20 20V18C20 15.34 14.67 14 12 14Z"
      fill="currentColor"
    />
  </svg>`,
        label: 'Usuarios',
       // route: '/users',
        route:  route('users.index'),
      },
      {
        icon: `<svg
    class="fill-current"
    width="18"
    height="18"
    viewBox="0 0 24 24"
    xmlns="http://www.w3.org/2000/svg"
  >
    <path
      d="M3 4C3 3.45 3.45 3 4 3H20C20.55 3 21 3.45 21 4V6C21 6.55 20.55 7 20 7H4C3.45 7 3 6.55 3 6V4ZM3 10C3 9.45 3.45 9 4 9H20C20.55 9 21 9.45 21 10V12C21 12.55 20.55 13 20 13H4C3.45 13 3 12.55 3 12V10ZM4 15C3.45 15 3 15.45 3 16V18C3 18.55 3.45 19 4 19H12C12.55 19 13 18.55 13 18V16C13 15.45 12.55 15 12 15H4Z"
      fill="currentColor"
    />
  </svg>`
        ,
        label: 'Inventario',
        //route: '/inventories',
        route:  route('inventories.index'),
      },
      {
        icon: `<svg
    class="fill-current"
    width="18"
    height="18"
    viewBox="0 0 24 24"
    xmlns="http://www.w3.org/2000/svg"
  >
    <path
      d="M3 5C2.45 5 2 5.45 2 6V18C2 18.55 2.45 19 3 19H21C21.55 19 22 18.55 22 18V6C22 5.45 21.55 5 21 5H3ZM4 7H20V9H4V7ZM4 11H20V17H4V11ZM7 14C6.45 14 6 14.45 6 15C6 15.55 6.45 16 7 16C7.55 16 8 15.55 8 15C8 14.45 7.55 14 7 14Z"
      fill="currentColor"
    />
  </svg>`
        ,
        label: 'Metodos de pagos',
       // route: '/paymentmethods',
        route:  route('paymentmethods.index'),
      },
      {
        icon: `<svg
    class="fill-current"
    width="18"
    height="18"
    viewBox="0 0 24 24"
    xmlns="http://www.w3.org/2000/svg"
  >
    <path
      d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.58 20 4 16.42 4 12C4 7.58 7.58 4 12 4C16.42 4 20 7.58 20 12C20 16.42 16.42 20 12 20ZM12 6C11.45 6 11 6.45 11 7V12C11 12.55 11.45 13 12 13C12.55 13 13 12.55 13 12V7C13 6.45 12.55 6 12 6ZM12 16C11.45 16 11 16.45 11 17C11 17.55 11.45 18 12 18C12.55 18 13 17.55 13 17C13 16.45 12.55 16 12 16Z"
      fill="currentColor"
    />
  </svg>`
        ,
        label: 'Razon',
        //route: '/reasons',
         route:  route('reasons.index'),
      },
      {
        icon: `<svg
    class="fill-current"
    width="18"
    height="18"
    viewBox="0 0 24 24"
    xmlns="http://www.w3.org/2000/svg"
  >
    <path
      d="M4 4H20C20.55 4 21 4.45 21 5V19C21 19.55 20.55 20 20 20H4C3.45 20 3 19.55 3 19V5C3 4.45 3.45 4 4 4ZM5 6V18H19V6H5ZM7 8H17C17.55 8 18 8.45 18 9C18 9.55 17.55 10 17 10H7C6.45 10 6 9.55 6 9C6 8.45 6.45 8 7 8ZM7 12H17C17.55 12 18 12.45 18 13C18 13.55 17.55 14 17 14H7C6.45 14 6 13.55 6 13C6 12.45 6.45 12 7 12ZM7 16H13C13.55 16 14 16.45 14 17C14 17.55 13.55 18 13 18H7C6.45 18 6 17.55 6 17C6 16.45 6.45 16 7 16Z"
      fill="currentColor"
    />
  </svg>`
        ,
        label: 'Detalle inventario',
        //route: '/inventorydetails',
        route:  route('inventorydetails.index'),
      },
      {
        icon: `<svg
    class="fill-current"
    width="18"
    height="18"
    viewBox="0 0 24 24"
    xmlns="http://www.w3.org/2000/svg"
  >
    <path
      d="M12 2C6.48 2 2 6.48 2 12C2 12.55 2.45 13 3 13C3.55 13 4 12.55 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20C10.24 20 8.6 19.47 7.22 18.53C6.89 18.31 6.42 18.42 6.2 18.75C5.98 19.08 6.09 19.55 6.42 19.77C8.01 20.83 9.95 21.5 12 21.5C17.52 21.5 22 17.02 22 12C22 6.98 17.52 2.5 12 2.5ZM12 8C11.45 8 11 8.45 11 9V11H9C8.45 11 8 11.45 8 12C8 12.55 8.45 13 9 13H11V15C11 15.55 11.45 16 12 16C12.55 16 13 15.55 13 15V13H15C15.55 13 16 12.55 16 12C16 11.45 15.55 11 15 11H13V9C13 8.45 12.55 8 12 8Z"
      fill="currentColor"
    />
  </svg>`
        ,
        label: 'Devolucion',
       // route: '/devoluciones',
         route:  route('devoluciones.index'),
      },
      {
        icon: `<svg
    class="fill-current"
    width="18"
    height="18"
    viewBox="0 0 24 24"
    xmlns="http://www.w3.org/2000/svg"
  >
    <path
      d="M8 2C6.9 2 6 2.9 6 4V20C6 21.1 6.9 22 8 22H16C17.1 22 18 21.1 18 20V8L13 2H8ZM8 4H12V8H16V20H8V4ZM14.5 13C14.5 14.1 13.6 15 12.5 15H11C10.45 15 10 15.45 10 16C10 16.55 10.45 17 11 17H12.5C13.6 17 14.5 17.9 14.5 19C14.5 20.1 13.6 21 12.5 21H11C9.9 21 9 20.1 9 19H10.5C10.5 19.55 10.95 20 11.5 20H12.5C13.05 20 13.5 19.55 13.5 19C13.5 18.45 13.05 18 12.5 18H11C9.9 18 9 17.1 9 16C9 14.9 9.9 14 11 14H12.5C13.05 14 13.5 13.55 13.5 13H14.5Z"
      fill="currentColor"
    />
  </svg>`
        ,
        label: 'Nota de venta',
        //route: '/notaventas',
          route:  route('notaventas.index'),
      },
      {
        icon: `<svg
    class="fill-current"
    width="18"
    height="18"
    viewBox="0 0 24 24"
    xmlns="http://www.w3.org/2000/svg"
  >
    <path
      d="M12 12C14.76 12 17 9.76 17 7C17 4.24 14.76 2 12 2C9.24 2 7 4.24 7 7C7 9.76 9.24 12 12 12ZM4 18C4 15.34 9.33 14 12 14C14.67 14 20 15.34 20 18V20C20 20.55 19.55 21 19 21H5C4.45 21 4 20.55 4 20V18Z"
      fill="currentColor"
    />
  </svg>`
        ,
        label: 'Cliente',
        //route: '/clientes',
        route:  route('clientes.index'),
      },
      {
        icon: `<svg
   class="fill-current"
  width="18"
  height="18"
  viewBox="0 0 24 24"
  xmlns="http://www.w3.org/2000/svg"
>
  <path
    d="M3 4C3 3.45 3.45 3 4 3H5L6.68 7.18L8.21 14.4L14.3 13.43C14.8 13.34 15.2 13.68 15.29 14.18C15.38 14.67 15.03 15.07 14.53 15.16L8.94 16.13L8.3 18.3C8.16 18.73 7.84 19 7.47 19H4C3.45 19 3 18.55 3 18V4ZM21 6H6C5.45 6 5 6.45 5 7V17C5 17.55 5.45 18 6 18H21C21.55 18 22 17.55 22 17V7C22 6.45 21.55 6 21 6ZM19 15C19.55 15 20 14.55 20 14C20 13.45 19.55 13 19 13C18.45 13 18 13.45 18 14C18 14.55 18.45 15 19 15ZM16 15C16.55 15 17 14.55 17 14C17 13.45 16.55 13 16 13C15.45 13 15 13.45 15 14C15 14.55 15.45 15 16 15Z"
    fill="currentColor"
  />
  </svg>`,
        label: 'Detalle venta',
      //  route: '/detalleventas',
        route:  route('detalleventas.index'),
      },

      {
        icon: `<svg
  class="fill-current"
  width="18"
  height="18"
  viewBox="0 0 24 24"
  xmlns="http://www.w3.org/2000/svg"
>
  <path
    d="M19 2H10C8.9 2 8 2.9 8 4V20C8 21.1 8.9 22 10 22H19C20.1 22 21 21.1 21 20V4C21 2.9 20.1 2 19 2ZM11 5H18V7H11V5ZM11 9H18V11H11V9ZM11 13H15V15H11V13ZM5 4H7V20H5C3.9 20 3 19.1 3 18V6C3 4.9 3.9 4 5 4Z"
    fill="currentColor"
  />
</svg>`,
        label: 'Nota Compra',
        //route: '/notacompras',
         route:  route('notacompras.index'),
      },
      {
        icon: `<svg
  class="fill-current"
  width="18"
  height="18"
  viewBox="0 0 24 24"
  xmlns="http://www.w3.org/2000/svg"
>
  <path
    d="M19 2H5C3.9 2 3 2.9 3 4V20C3 21.1 3.9 22 5 22H19C20.1 22 21 21.1 21 20V4C21 2.9 20.1 2 19 2ZM11 7H17V9H11V7ZM7 7H9V9H7V7ZM11 11H17V13H11V11ZM7 11H9V13H7V11ZM11 15H17V17H11V15ZM7 15H9V17H7V15Z"
    fill="currentColor"
  />
</svg>
`,
        label: 'Detalle Compra',
      //  route: '/detallecompras',
        route:  route('detallecompras.index'),
      },
      {
        icon: `<svg
  class="fill-current"
  width="18"
  height="18"
  viewBox="0 0 24 24"
  xmlns="http://www.w3.org/2000/svg"
>
  <path
    d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.58 20 4 16.42 4 12C4 7.58 7.58 4 12 4C16.42 4 20 7.58 20 12C20 16.42 16.42 20 12 20ZM13 7H11V13H16V11H13V7Z"
    fill="currentColor"
  />
</svg>
`,
        label: 'Caducidad',
        //route: '/caducidades',
        route: route("caducidades.index"),
      },
//       {
//         icon: `<svg
//   class="fill-current"
//   width="18"
//   height="18"
//   viewBox="0 0 24 24"
//   xmlns="http://www.w3.org/2000/svg"
// >
//   <path
//     d="M3 4H21V6H3V4ZM3 9H16V11H3V9ZM3 14H21V16H3V14ZM3 19H16V21H3V19ZM18 9H21V11H18V9ZM18 14H21V16H18V14Z"
//     fill="currentColor"
//   />
// </svg>
// `,
//         label: 'Detalle Cantidad Venta',
//         //route: '/detallecantidadventas',
//          route:  route('detallecantidadventas.index'),
//       },
      {
        icon: `<svg
  class="fill-current"
  width="18"
  height="18"
  viewBox="0 0 24 24"
  xmlns="http://www.w3.org/2000/svg"
>
  <path
    d="M7 18C5.9 18 5 18.9 5 20C5 21.1 5.9 22 7 22C8.1 22 9 21.1 9 20C9 18.9 8.1 18 7 18ZM1 2V4H3L6.6 12.59L5.25 14.91C5.09 15.17 5 15.48 5 15.8C5 16.92 5.9 17.82 7 17.82H19V15.82H7.42C7.28 15.82 7.17 15.7 7.17 15.56L7.2 15.49L8.1 13.82H15.55C16.3 13.82 16.97 13.42 17.3 12.82L20.88 6.12C21.03 5.84 21.12 5.52 21.12 5.19C21.12 4.47 20.59 3.82 19.88 3.82H5.21L4.27 2H1ZM17 18C15.9 18 15 18.9 15 20C15 21.1 15.9 22 17 22C18.1 22 19 21.1 19 20C19 18.9 18.1 18 17 18ZM12 8V5H15V3H12V0H10V3H7V5H10V8H12Z"
    fill="currentColor"
  />
</svg>
`,
        label: "Realizar compra",
        route: route("detallecompras.create"), // Usar la ruta dinámica generada
      },
      {
        icon: `<svg
  class="fill-current"
  width="18"
  height="18"
  viewBox="0 0 24 24"
  xmlns="http://www.w3.org/2000/svg"
>
  <path
    d="M7 18C5.9 18 5 18.9 5 20C5 21.1 5.9 22 7 22C8.1 22 9 21.1 9 20C9 18.9 8.1 18 7 18ZM1 2V4H3L6.6 12.59L5.25 14.91C5.09 15.17 5 15.48 5 15.8C5 16.92 5.9 17.82 7 17.82H19V15.82H7.42C7.28 15.82 7.17 15.7 7.17 15.56L7.2 15.49L8.1 13.82H15.55C16.3 13.82 16.97 13.42 17.3 12.82L20.88 6.12C21.03 5.84 21.12 5.52 21.12 5.19C21.12 4.47 20.59 3.82 19.88 3.82H5.21L4.27 2H1ZM17 18C15.9 18 15 18.9 15 20C15 21.1 15.9 22 17 22C18.1 22 19 21.1 19 20C19 18.9 18.1 18 17 18ZM13 10H16L12 14L8 10H11V6H13V10Z"
    fill="currentColor"
  />
</svg>
`,
        label: "Realizar Venta",
        route: route("clientes.create"), // Usar la ruta dinámica generada
      },
    ]
  },
  {
    name: 'Gestión de usuarios',
    menuItems: [
      {
        icon: `<svg
            class="fill-current"
            width="22"
            height="18"
            viewBox="0 0 22 18"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M7.18418 8.03751C9.31543 8.03751 11.0686 6.35313 11.0686 4.25626C11.0686 2.15938 9.31543 0.475006 7.18418 0.475006C5.05293 0.475006 3.2998 2.15938 3.2998 4.25626C3.2998 6.35313 5.05293 8.03751 7.18418 8.03751ZM7.18418 2.05626C8.45605 2.05626 9.52168 3.05313 9.52168 4.29063C9.52168 5.52813 8.49043 6.52501 7.18418 6.52501C5.87793 6.52501 4.84668 5.52813 4.84668 4.29063C4.84668 3.05313 5.9123 2.05626 7.18418 2.05626Z"
              fill=""
            />
            <path
              d="M15.8124 9.6875C17.6687 9.6875 19.1468 8.24375 19.1468 6.42188C19.1468 4.6 17.6343 3.15625 15.8124 3.15625C13.9905 3.15625 12.478 4.6 12.478 6.42188C12.478 8.24375 13.9905 9.6875 15.8124 9.6875ZM15.8124 4.7375C16.8093 4.7375 17.5999 5.49375 17.5999 6.45625C17.5999 7.41875 16.8093 8.175 15.8124 8.175C14.8155 8.175 14.0249 7.41875 14.0249 6.45625C14.0249 5.49375 14.8155 4.7375 15.8124 4.7375Z"
              fill=""
            />
            <path
              d="M15.9843 10.0313H15.6749C14.6437 10.0313 13.6468 10.3406 12.7874 10.8563C11.8593 9.61876 10.3812 8.79376 8.73115 8.79376H5.67178C2.85303 8.82814 0.618652 11.0625 0.618652 13.8469V16.3219C0.618652 16.975 1.13428 17.4906 1.7874 17.4906H20.2468C20.8999 17.4906 21.4499 16.9406 21.4499 16.2875V15.4625C21.4155 12.4719 18.9749 10.0313 15.9843 10.0313ZM2.16553 15.9438V13.8469C2.16553 11.9219 3.74678 10.3406 5.67178 10.3406H8.73115C10.6562 10.3406 12.2374 11.9219 12.2374 13.8469V15.9438H2.16553V15.9438ZM19.8687 15.9438H13.7499V13.8469C13.7499 13.2969 13.6468 12.7469 13.4749 12.2313C14.0937 11.7844 14.8499 11.5781 15.6405 11.5781H15.9499C18.0812 11.5781 19.8343 13.3313 19.8343 15.4625V15.9438H19.8687Z"
              fill=""
            />
          </svg>`,
        label: 'Roles',
          route:  route('roles.index'),
       // route: '/roles'
      }

    ]
  }
])
</script>

<template>
  <aside
    class="absolute left-0 top-0 z-9999 flex h-screen w-72.5 flex-col overflow-y-hidden bg-black duration-300 ease-linear dark:bg-boxdark lg:static lg:translate-x-0"
    :class="{
      'translate-x-0': sidebarStore.isSidebarOpen,
      '-translate-x-full': !sidebarStore.isSidebarOpen
    }" ref="target">
    <!-- SIDEBAR HEADER -->
    <div class="flex items-center justify-between gap-2 px-6 py-5.5 lg:py-6.5">
      <router-link to="/">
        <h1 class="text-3xl	font-bold text-white">Farmacia Alicia</h1>
      </router-link>

      <button class="block lg:hidden" @click="sidebarStore.isSidebarOpen = false">
        <svg class="fill-current" width="20" height="18" viewBox="0 0 20 18" fill="none"
          xmlns="http://www.w3.org/2000/svg">
          <path
            d="M19 8.175H2.98748L9.36248 1.6875C9.69998 1.35 9.69998 0.825 9.36248 0.4875C9.02498 0.15 8.49998 0.15 8.16248 0.4875L0.399976 8.3625C0.0624756 8.7 0.0624756 9.225 0.399976 9.5625L8.16248 17.4375C8.31248 17.5875 8.53748 17.7 8.76248 17.7C8.98748 17.7 9.17498 17.625 9.36248 17.475C9.69998 17.1375 9.69998 16.6125 9.36248 16.275L3.02498 9.8625H19C19.45 9.8625 19.825 9.4875 19.825 9.0375C19.825 8.55 19.45 8.175 19 8.175Z"
            fill="" />
        </svg>
      </button>
    </div>
    <!-- SIDEBAR HEADER -->

    <div class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear">
      <!-- Sidebar Menu -->
      <nav class="mt-5 py-4 px-4 lg:mt-9 lg:px-6">
        <template v-for="menuGroup in menuGroups" :key="menuGroup.name">
          <div>
            <h3 class="mb-4 ml-4 text-sm font-medium text-bodydark2">{{ menuGroup.name }}</h3>

            <ul class="mb-6 flex flex-col gap-1.5">
              <SidebarItem v-for="(menuItem, index) in 
              menuGroup.menuItems" :item="menuItem" :key="index" :index="index" />
            </ul>
          </div>
        </template>
      </nav>

    </div>
  </aside>
</template>
