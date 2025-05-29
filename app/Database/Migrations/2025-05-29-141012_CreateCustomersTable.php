<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomersTable extends Migration
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
            'name' => [ // Nombre o Razón Social
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'document_number' => [ // DNI o RUC (texto simple, opcional)
                'type'       => 'VARCHAR',
                'constraint' => '20', // Suficiente para DNI (8) y RUC (11)
                'null'       => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
            ],
            'address' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [ // Para borrado suave
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('document_number'); // Clave para búsquedas, no necesariamente única si es opcional y puede ser nulo
        $this->forge->createTable('customers');
        
    }

    public function down()
    {
        $this->forge->dropTable('customers');
    }
}
