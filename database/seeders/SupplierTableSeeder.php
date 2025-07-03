<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'Supplier 1',
                'nombre_empresa'=>'Pollos yuya',
                'phone' => '098123123123'
            ]                      
        ];

        Supplier::insert($suppliers);
    }
}
