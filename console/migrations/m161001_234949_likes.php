<?php

use yii\db\Migration;

class m161001_234949_likes extends Migration
{
    public function SafeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%likes}}', [
            'user_id' => $this->integer()->notNull(),
            'geek_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('user-geek_pk', "{{%likes}}", ['user_id', 'geek_id']);

        $this->createIndex("user_like_index", "{{%likes}}", "user_id");
        $this->createIndex("geek_index", "{{%likes}}", "geek_id");

        $this->addForeignKey("FK_user_like", "{{%likes}}", "user_id", "{{%user}}", "id");
        $this->addForeignKey("FK_geek", "{{%likes}}", "geek_id", "{{%geeks}}", "id");

    }

    public function SafeDown()
    {
        $this->dropForeignKey("FK_user_like", "{{%likes}}");
        $this->dropForeignKey("FK_geek", "{{%likes}}");
        $this->dropTable('{{%likes}}');
    }
}
