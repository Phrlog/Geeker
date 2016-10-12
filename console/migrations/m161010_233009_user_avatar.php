<?php

use yii\db\Migration;

class m161010_233009_user_avatar extends Migration
{
    public function SafeUp()
    {
        $this->addColumn("{{%user}}", 'avatar', $this->string(255)->defaultValue(NULL));
        $this->addColumn("{{%user}}", 'thumbnail', $this->string(255)->defaultValue(NULL));
    }

    public function SafeDown()
    {
        $this->dropColumn("{{%user}}", 'avatar');
        $this->dropColumn("{{%user}}", 'thumbnail');
    }

}
