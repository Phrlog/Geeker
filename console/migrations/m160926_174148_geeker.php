<?php

use yii\db\Migration;

class m160926_174148_geeker extends Migration
{
    public function SafeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%geeks}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'text' => $this->string()->notNull(),
            'image' => $this->string(255),
            'thumbnail' => $this->string(255),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ], $tableOptions);

        $this->createIndex("geek_user", "{{%geeks}}", "user_id");
        $this->addForeignKey("FK_geek_user", "{{%geeks}}", "user_id", "{{%user}}", "id");
    }

    public function SafeDown()
    {
        $this->dropForeignKey("FK_geek_user", "{{%geeks}}");
        $this->dropTable('{{%geeks}}');
    }

}
