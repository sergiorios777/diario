<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'code' => [ // Código del producto
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'unique'     => true,
            ],
            'name' => [ // Nombre del producto
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'description' => [ // Descripción
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'unit_of_measure' => [ // Unidad de medida
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'sale_price' => [ // Precio de venta estándar
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
            ],
            'cost_price' => [ // Costo unitario estándar
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
            ],
            'initial_lot' => [ // Lote inicial (informativo)
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'category_name' => [ // Categoría como texto simple
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'stock_quantity' => [ // Cantidad en stock (se actualizará con compras/ventas)
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [ // Para soft deletes
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
