<?php
/**
 * Created by PhpStorm.
 * User: VIP
 * Date: 07.02.2019
 * Time: 12:57
 */

namespace app\models;


use app\entities\Players;
use app\entities\Teams;
use Sunra\PhpSimple\HtmlDomParser;
use yii\base\Model;

class CreateTeam extends Model
{
    public $url;
    /**
     * @var Teams
     */
    private $entity;

    public function rules()
    {
        return [
            [['url'], 'required'],
            [['url'], 'string'],
            [['url'], 'url'],
            [['url'], 'unique', 'targetClass' => Teams::class, 'targetAttribute' => 'url']
        ];
    }

    public function create(): bool
    {
        if ($this->validate()) {
            $this->entity = new Teams();
            $this->entity->url = $this->url;
            $this->parse();
            if (!$this->hasErrors()) {
                return true;
            }
        }
        return false;
    }

    public function parse() :Teams
    {
        $baseUrl = "https://www.hltv.org";
        $html = HtmlDomParser::file_get_html($this->entity->url, false, null, 0);
        /* Используется xpath так как на странице не к чему привязываться,
        поэтому - при изменении верстки достаточно будет изменить путь */
        $paths = [
            'maps_played' => '/html/body/div[2]/div/div[2]/div[1]/div/div[5]/div[1]/div[1]',
            'total_deaths' => '/html/body/div[2]/div/div[2]/div[1]/div/div[7]/div[1]/div[1]',
            'total_kills' => '/html/body/div[2]/div/div[2]/div[1]/div/div[5]/div[3]/div[1]',
            'wins_draws_losses' => '/html/body/div[2]/div/div[2]/div[1]/div/div[5]/div[2]/div[1]',
            'rounds_played' => '/html/body/div[2]/div/div[2]/div[1]/div/div[7]/div[2]/div[1]',
            'kd_ratio' => '/html/body/div[2]/div/div[2]/div[1]/div/div[7]/div[3]/div[1]'
        ];
        \Yii::debug($this->url);
        /* Заполнение информации о команде*/
        foreach ($paths as $name => $path) {
            $element = $html->find($path, 0);
            if($element) {
                $this->entity->$name = $element->text();
            }
        }
        if ($this->entity->save()) {
            /* Поиск ссылки на страницу с игроками */
            $player_page_link_path = '/html/body/div[2]/div/div[2]/div[1]/div/div[3]/div/div/a[4]';
            $url = $html->find($player_page_link_path, 0) ? $baseUrl . $html->find($player_page_link_path, 0)->getAttribute('href') : null;
            if (!empty($url)) {
                $html = HtmlDomParser::file_get_html($url, false, null, 0);
                /* Поиск таблицы со списком игроков */
                $player_table_path = '.player-ratings-table tr';
                foreach ($html->find($player_table_path) as $tr) {
                    if ($tr->parent->tag == 'tbody') {
                        /* Заполнение игроков */
                        $player = new Players();
                        $player->player = $tr->first_child()->text();
                        $player->maps = $tr->children(1)->text();
                        $player->kd_diff = $tr->children(2)->text();
                        $player->kd = $tr->children(3)->text();
                        $player->rating = $tr->children(4)->text();
                        $player->link('team', $this->entity);
                    }
                }
            }
        } else {
            $this->addError('url', \Yii::t('app', 'Некорректная ссылка'));
        }
        return $this->entity;
    }

    /**
     * @return Teams
     */
    public function getEntity(): Teams
    {
        return $this->entity;
    }
}