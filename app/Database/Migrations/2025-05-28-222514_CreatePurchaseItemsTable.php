<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePurchaseItemsTable extends Migration
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
            'purchase_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'product_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'quantity' => [
                'type'       => 'DECIMAL', // O INT si tus productos siempre son unidades enteras
                'constraint' => '10,2',
                'default'    => 1.00,
            ],
            'unit_cost' => [ // Costo unitario del producto en esta compra específica
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
            ],
            'subtotal' => [ // Calculado: quantity * unit_cost
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0.00,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        // Se implementará deleted_at posterioremente por su implicancia en la devolución de productos
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('purchase_id', 'purchases', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'RESTRICT'); // RESTRICT para no borrar productos con compras
        $this->forge->createTable('purchase_items');
        
    }

    public function down()
    {
        $this->forge->dropForeignKey('purchase_items', 'purchase_items_purchase_id_foreign');
        $this->forge->dropForeignKey('purchase_items', 'purchase_items_product_id_foreign');
        $this->forge->dropTable('purchase_items', true);
    }
}
