<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Produtos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'preco' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'status' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,  // Valor padrão é 1 (ativo)
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('produtos');
    }

    public function down()
    {
        $this->forge->dropTable('produtos');
    }

}