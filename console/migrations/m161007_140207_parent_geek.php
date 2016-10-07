<?php

use yii\db\Migration;

class m161007_140207_parent_geek extends Migration
{
    public function SafeUp()
    {
        $this->addColumn("{{%geeks}}", 'parent_id', $this->integer()->defaultValue(NULL) . ' AFTER user_id');
        $this->addForeignKey("FK_parent_geek", "{{%geeks}}", "parent_id", "{{%geeks}}", "id");
    }

    public function SafeDown()
    {
        $this->dropForeignKey("FK_parent_geek", "{{%geeks}}");
        $this->dropColumn("{{%geeks}}", 'parent_id');
    }

}
