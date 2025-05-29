<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePurchasesTable extends Migration
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
            'supplier_id' => [ // Asumiendo que tienes una tabla 'suppliers' del módulo de Proveedores
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true, // O false si el proveedor es siempre obligatorio y seleccionado
            ],
            'supplier_name_text' => [ // Campo para nombre de proveedor si no se selecciona de la lista (MVP)
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'purchase_date' => [
                'type' => 'DATE',
            ],
            'reference_no' => [ // Número de factura/guía del proveedor (opcional)
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'total_amount' => [ // Calculado: suma de subtotales de los ítems
                'type'       => 'DECIMAL',
                'constraint' => '15,2', // Ajusta según necesidad
                'default'    => 0.00,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
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
        // Asegúrate de que la tabla 'suppliers' exista si vas a usar esta FK.
        // $this->forge->addForeignKey('supplier_id', 'suppliers', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('purchases');
    }

    public function down()
    {
        $this->forge->dropTable('purchases', true);
        // Si tienes una FK, asegúrate de eliminarla antes de eliminar la tabla.
        // $this->forge->dropForeignKey('purchases', 'purchases_supplier_id_foreign');
    }
}
