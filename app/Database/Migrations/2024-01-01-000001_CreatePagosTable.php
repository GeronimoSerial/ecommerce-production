<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePagosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'payment_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'null' => false,
                'comment' => 'ID del pago de MercadoPago'
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
                'comment' => 'Estado del pago: pending, approved, rejected, cancelled, etc.'
            ],
            'detail' => [
                'type' => 'JSON',
                'null' => false,
                'comment' => 'Detalles completos del pago en formato JSON'
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => false,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP')
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('payment_id');
        $this->forge->addKey('status');
        $this->forge->createTable('pagos');
    }

    public function down()
    {
        $this->forge->dropTable('pagos');
    }
} 