<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Clientes extends Migration
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
            'cpf_cnpj' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'nome_razao_social' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
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
        $this->forge->createTable('clientes');
    }

    public function down()
    {
        $this->forge->dropTable('clientes');
    }

}