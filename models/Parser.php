<?php
/**
 * Created by PhpStorm.
 * User: VIP
 * Date: 07.02.2019
 * Time: 10:11
 */

namespace app\models;

use app\entities\Teams;
use app\src\Overview;
use app\src\Player;
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
     * @return Overview результат
     */
    public static function parse(Teams $team): Overview
    {
        return self::parseByUrl($team->url);
    }

    public static function parseByUrl(string $url) :Overview
    {
        $overview = new Overview();
        $baseUrl = "https://www.hltv.org";
        $html = HtmlDomParser::file_get_html($url, false, null, 0);
        /* Используется xpath так как на странице не к чему привязываться,
        поэтому - при изменении верстки достаточно будет изменить путь */
        $paths = [
            'maps_played' => '/html/body/div[2]/div/div[2]/div[1]/div/div[5]/div[1]/div[1]',
            'total_death' => '/html/body/div[2]/div/div[2]/div[1]/div/div[7]/div[1]/div[1]',
            'total_kills' => '/html/body/div[2]/div/div[2]/div[1]/div/div[5]/div[3]/div[1]',
            'wins_draws_losses' => '/html/body/div[2]/div/div[2]/div[1]/div/div[5]/div[2]/div[1]',
            'rounds_played' => '/html/body/div[2]/div/div[2]/div[1]/div/div[7]/div[2]/div[1]',
            'kd_ratio' => '/html/body/div[2]/div/div[2]/div[1]/div/div[7]/div[3]/div[1]'
        ];
        /* Заполнение информации о команде*/
        foreach ($paths as $name => $path) {
            $overview->$name = $html->find($path, 0)->text();
        }
        /* Поиск ссылки на страницу с игроками */
        $player_page_link_path = '/html/body/div[2]/div/div[2]/div[1]/div/div[3]/div/div/a[4]';
        $url = $html->find($player_page_link_path, 0) ? $baseUrl . $html->find($player_page_link_path, 0)->getAttribute('href'): null;
        if(!empty($url)) {
            $html = HtmlDomParser::file_get_html($url, false, null, 0);
            /* Поиск таблицы со списком игроков */
            $player_table_path = '.player-ratings-table tr';
            foreach ($html->find($player_table_path) as $tr) {
                if($tr->parent->tag == 'tbody') {
                    /* Заполнение игроков */
                    $player = new Player();
                    $player->name = $tr->first_child()->text();
                    $player->maps = $tr->children(1)->text();
                    $player->kd_diff = $tr->children(2)->text();
                    $player->kd = $tr->children(3)->text();
                    $player->rating = $tr->children(4)->text();
                    $overview->players[] = $player;
                }
            }
        }
        return $overview;
    }
}