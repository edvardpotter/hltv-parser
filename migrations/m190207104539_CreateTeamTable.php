<?php

use yii\db\Migration;

/**
 * Class m190206_184539_CreateTeamTable
 */
class m190207104539_CreateTeamTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('teams', [
            'id' => $this->primaryKey(),
            'url' => $this->string()->notNull()->comment('Ссылка')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('teams');
    }
}
