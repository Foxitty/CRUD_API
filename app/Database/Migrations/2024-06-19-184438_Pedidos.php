<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pedidos extends Migration
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
            'cliente_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'produto_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'status' => [
                'type' => 'INT',
                'unsigned' => true,
                'default' => '0',// Valor padrão é 0= Em Aberto, 1 = Pago e 2 = cancelado
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
        $this->forge->addForeignKey('cliente_id', 'clientes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('produto_id', 'produtos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pedidos');
    }

    public function down()
    {
        $this->forge->dropTable('pedidos');
    }

}