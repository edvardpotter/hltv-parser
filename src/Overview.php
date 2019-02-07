<?php
/**
 * Created by PhpStorm.
 * User: VIP
 * Date: 07.02.2019
 * Time: 10:24
 */

namespace app\src;


/**
 * Class Overview
 * @package app\src
 */
class Overview
{
    /**
     * @var int
     */
    public $maps_played;
    /**
     * @var string
     */
    public $wins_draws_losses;
    /**
     * @var int
     */
    public $total_kills;
    /**
     * @var int
     */
    public $total_death;
    /**
     * @var int
     */
    public $rounds_played;
    /**
     * @var double
     */
    public $kd_ratio;
    /**
     * @var Player[]
     */
    public $players;
}