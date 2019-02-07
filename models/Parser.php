<?php
/**
 * Created by PhpStorm.
 * User: VIP
 * Date: 07.02.2019
 * Time: 10:11
 */

namespace app\models;

use app\entities\Players;
use app\entities\Teams;
use Sunra\PhpSimple\HtmlDomParser;
use yii\base\Model;

/**
 * Class Parser
 * @package app\models
 */
class Parser extends Model
{
    /**
     * Парсит страницу по команде которая была добавлена ранее
     * @param Teams $team команда
     */
    public static function parse(Teams $team)
    {

    }
}