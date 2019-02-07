<?php

use yii\db\Migration;

/**
 * Class m190206_184539_CreateTeamTable
 */
class m190207104539_Main extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('teams', [
            'id' => $this->primaryKey(),
            'url' => $this->string()->notNull()->comment('Ссылка'),
            'maps_played' => $this->integer()->notNull(),
            'wins_draws_losses' => $this->string()->notNull(),
            'total_kills' => $this->integer()->notNull(),
            'total_deaths' => $this->integer()->notNull(),
            'rounds_played' => $this->integer()->notNull(),
            'kd_ratio' => $this->double()->notNull(),
        ]);
        $this->createTable('players', [
            'id' => $this->primaryKey(),
            'team_id' => $this->integer(),
            'player' => $this->string()->notNull(),
            'maps' => $this->integer()->notNull(),
            'kd_diff' => $this->integer()->notNull(),
            'kd' => $this->double()->notNull(),
            'rating' => $this->double()->notNull(),
        ]);
        $this->addForeignKey(
            'fk-players_team_id_teams_id',
            'players',
            'team_id',
            'teams',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('players');
        $this->dropTable('teams');
    }
}
