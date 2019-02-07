<?php

namespace app\entities;

use Yii;

/**
 * This is the model class for table "teams".
 *
 * @property int $id
 * @property string $url Ссылка
 * @property int $maps_played
 * @property string $wins_draws_losses
 * @property int $total_kills
 * @property int $total_deaths
 * @property int $rounds_played
 * @property double $kd_ratio
 *
 * @property Players[] $players
 */
class Teams extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'teams';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'maps_played', 'wins_draws_losses', 'total_kills', 'total_deaths', 'rounds_played', 'kd_ratio'], 'required'],
            [['maps_played', 'total_kills', 'total_deaths', 'rounds_played'], 'integer'],
            [['kd_ratio'], 'number'],
            [['url', 'wins_draws_losses'], 'string', 'max' => 255],
            ['url', 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Ссылка',
            'maps_played' => 'Maps Played',
            'wins_draws_losses' => 'Wins Draws Losses',
            'total_kills' => 'Total Kills',
            'total_deaths' => 'Total Deaths',
            'rounds_played' => 'Rounds Played',
            'kd_ratio' => 'Kd Ratio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlayers()
    {
        return $this->hasMany(Players::class, ['team_id' => 'id']);
    }
}
