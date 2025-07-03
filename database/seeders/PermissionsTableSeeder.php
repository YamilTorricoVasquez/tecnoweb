<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'title' => 'crear_roles',
            ],
            [
                'title' => 'editar_roles',
            ],
           
            [
                'title' => 'eliminar_roles',
            ],
            [
                'title' => 'ver_roles',
            ],

            [
                'title' => 'ver_medicamentos',
            ],
            [
                'title' => 'crear_medicamentos',
            ],
            [
                'title' => 'editar_medicamentos',
            ],
            [
                'title' => 'eliminar_medicamentos',
            ],
            
            [
                'title' => 'ver_categorias',
            ],
            [
                'title' => 'crear_categorias',
            ],
            [
                'title' => 'editar_categorias',
            ],
           
            [
                'title' => 'eliminar_categorias',
            ],

            [
                'title' => 'ver_proveedores',
            ],
            // [
            //     'title' => 'crear_proveedores',
            // ],
            [
                'title' => 'editar_proveedores',
            ],
           
            [
                'title' => 'eliminar_proveedores',
            ],

            [
                'title' => 'ver_usuarios',
            ],
            [
                'title' => 'crear_usuarios',
            ],
            [
                'title' => 'editar_usuarios',
            ],
           
            [
                'title' => 'eliminar_usuarios',
            ],


            [
                'title' => 'ver_inventarios',
            ],
            [
                'title' => 'crear_inventarios',
            ],
            [
                'title' => 'editar_inventarios',
            ],
            
            [
                'title' => 'eliminar_inventarios',
            ],

            [
                'title' => 'ver_metodos_pagos',
            ],
            [
                'title' => 'crear_metodos_pagos',
            ],
            [
                'title' => 'editar_metodos_pagos',
            ],
           
            [
                'title' => 'eliminar_metodos_pagos',
            ],

            [
                'title' => 'ver_razones',
            ],
            [
                'title' => 'crear_razones',
            ],
            [
                'title' => 'editar_razones',
            ],
            
            [
                'title' => 'eliminar_razones',
            ],



            [
                'title' => 'ver_detalles_inventarios',
            ],
          
            [
                'title' => 'editar_detalles_inventarios',
            ],

            



            // [
            //     'title' => 'return_access',
            // ],
            // [
            //     'title' => 'return_create',
            // ],
            // [
            //     'title' => 'return_edit',
            // ],
            // [
            //     'title' => 'return_show',
            // ],
            // [
            //     'title' => 'return_delete',
            // ],

            [
                'title' => 'ver_caducidades',
            ],

            [
                'title' => 'ver_detalle_cantidad_venta',
            ],


            [
                'title' => 'ver_detalle_compra',
            ],
            // [
            //     'title' => 'crear_detalle_compra',
            // ],

            [
                'title' => 'ver_detalle_venta',
            ],
            // [
            //     'title' => 'crear_detalle_venta',
            // ],
            [
                'title' => 'eliminar_detalle_venta',
            ],
            

            [
                'title' => 'ver_devoluciones',
            ],
            [
                'title' => 'crear_devoluciones',
            ],
            [
                'title' => 'editar_devoluciones',
            ],
            [
                'title' => 'eliminar_devoluciones',
            ],

            [
                'title' => 'ver_detalles_inventarios',
            ],
            [
                'title' => 'editar_detalles_inventarios',
            ],

            [
                'title' => 'ver_notas_compras',
            ],
            // [
            //     'title' => 'crear_notas_compras',
            // ],
            [
                'title' => 'Realizar_compra',
            ],

            [
                'title' => 'ver_notas_ventas',
            ],
            // [
            //     'title' => 'crear_notas_ventas',
            // ],

            [
                'title' => 'ver_clientes',
            ],
            // [
            //     'title' => 'crear_clientes',
            // ],
            [
                'title' => 'Realizar_venta',
            ],
            [
                'title' => 'editar_clientes',
            ],
            [
                'title' => 'eliminar_clientes',
            ],
            



        ];

        Permission::insert($permissions);
    }
}
