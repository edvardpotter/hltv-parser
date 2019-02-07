<?php

namespace app\entities;

use Yii;

/**
 * This is the model class for table "players".
 *
 * @property int $id
 * @property int $team_id
 * @property string $player
 * @property int $maps
 * @property int $kd_diff
 * @property double $kd
 * @property double $rating
 *
 * @property Teams $team
 */
class Players extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'players';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['team_id', 'maps', 'kd_diff'], 'integer'],
            [['player', 'maps', 'kd_diff', 'kd', 'rating'], 'required'],
            [['kd', 'rating'], 'number'],
            [['player'], 'string', 'max' => 255],
            [['team_id'], 'exist', 'skipOnError' => true, 'targetClass' => Teams::class, 'targetAttribute' => ['team_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'team_id' => 'Team ID',
            'player' => 'Player',
            'maps' => 'Maps',
            'kd_diff' => 'Kd Diff',
            'kd' => 'Kd',
            'rating' => 'Rating',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Teams::class, ['id' => 'team_id']);
    }
}
