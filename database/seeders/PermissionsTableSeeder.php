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
                'title' => 'role_create',
            ],
            [
                'title' => 'role_edit',
            ],
            [
                'title' => 'role_show',
            ],
            [
                'title' => 'role_delete',
            ],
            [
                'title' => 'role_access',
            ],
            [
                'title' => 'product_create',
            ],
            [
                'title' => 'product_edit',
            ],
            [
                'title' => 'product_show',
            ],
            [
                'title' => 'product_delete',
            ],
            [
                'title' => 'product_access',
            ],
            [
                'title' => 'category_access',
            ],
            [
                'title' => 'category_create',
            ],
            [
                'title' => 'category_edit',
            ],
            [
                'title' => 'category_show',
            ],
            [
                'title' => 'category_delete',
            ],
            [
                'title' => 'supplier_access',
            ],
            [
                'title' => 'supplier_create',
            ],
            [
                'title' => 'supplier_edit',
            ],
            [
                'title' => 'supplier_show',
            ],
            [
                'title' => 'supplier_delete',
            ],

            [
                'title' => 'user_access',
            ],
            [
                'title' => 'user_create',
            ],
            [
                'title' => 'user_edit',
            ],
            [
                'title' => 'user_show',
            ],
            [
                'title' => 'user_delete',
            ],


            [
                'title' => 'inventory_access',
            ],
            [
                'title' => 'inventory_create',
            ],
            [
                'title' => 'inventory_edit',
            ],
            [
                'title' => 'inventory_show',
            ],
            [
                'title' => 'inventory_delete',
            ],

            [
                'title' => 'paymentmethod_access',
            ],
            [
                'title' => 'paymentmethod_create',
            ],
            [
                'title' => 'paymentmethod_edit',
            ],
            [
                'title' => 'paymentmethod_show',
            ],
            [
                'title' => 'paymentmethod_delete',
            ],

            [
                'title' => 'reason_access',
            ],
            [
                'title' => 'reason_create',
            ],
            [
                'title' => 'reason_edit',
            ],
            [
                'title' => 'reason_show',
            ],
            [
                'title' => 'reason_delete',
            ],



            [
                'title' => 'inventorydetail_access',
            ],
            [
                'title' => 'inventorydetail_create',
            ],
            [
                'title' => 'inventorydetail_edit',
            ],
            [
                'title' => 'inventorydetail_show',
            ],
            [
                'title' => 'inventorydetail_delete',
            ],



            [
                'title' => 'return_access',
            ],
            [
                'title' => 'return_create',
            ],
            [
                'title' => 'return_edit',
            ],
            [
                'title' => 'return_show',
            ],
            [
                'title' => 'return_delete',
            ],

            [
                'title' => 'caducidad_access',
            ],

            [
                'title' => 'detalle_cantidad_venta_access',
            ],


            [
                'title' => 'detalle_compra_access',
            ],
            [
                'title' => 'detalle_compra_create',
            ],

            [
                'title' => 'detalle_venta_access',
            ],
            [
                'title' => 'detalle_venta_create',
            ],
            [
                'title' => 'detalle_venta_delete',
            ],

            [
                'title' => 'devolucion_access',
            ],
            [
                'title' => 'devolucion_create',
            ],
            [
                'title' => 'devolucion_edit',
            ],
            [
                'title' => 'devolucion_delete',
            ],

            [
                'title' => 'inventorydetail_access',
            ],
            [
                'title' => 'inventorydetail_edit',
            ],

            [
                'title' => 'nota_compra_access',
            ],
            [
                'title' => 'nota_compra_create',
            ],

            [
                'title' => 'nota_venta_access',
            ],
            [
                'title' => 'nota_venta_create',
            ],

            [
                'title' => 'cliente_access',
            ],
            [
                'title' => 'cliente_create',
            ],
            [
                'title' => 'cliente_edit',
            ],
            [
                'title' => 'cliente_delete',
            ],
            



        ];

        Permission::insert($permissions);
    }
}
