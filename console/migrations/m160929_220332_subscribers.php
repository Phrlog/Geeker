<?php

use yii\db\Migration;

class m160929_220332_subscribers extends Migration
{
    public function SafeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%subscription}}', [
            'user_id' => $this->integer()->notNull(),
            'subscribe_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('user-subscribe_pk', "{{%subscription}}", ['user_id', 'subscribe_id']);

        $this->createIndex("User_index", "{{%subscription}}", "user_id");
        $this->createIndex("Subscribe_index", "{{%subscription}}", "subscribe_id");

        $this->addForeignKey("FK_user", "{{%subscription}}", "user_id", "{{%user}}", "id");
        $this->addForeignKey("FK_subscribe", "{{%subscription}}", "subscribe_id", "{{%user}}", "id");

    }

    public function SafeDown()
    {
        $this->dropForeignKey("FK_user", "{{%subscription}}");
        $this->dropForeignKey("FK_subscribe", "{{%subscription}}");
        $this->dropTable('{{%subscription}}');
    }
}
