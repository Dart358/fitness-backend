<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'post_id'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'user_id'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'content'       => ['type' => 'TEXT'],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('post_id', 'blog_posts', 'id');
        $this->forge->addForeignKey('user_id', 'users', 'id');
        $this->forge->createTable('comments');
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('comments');
    }
}
