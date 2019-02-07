<?php

namespace tests\unit\models;

use app\entities\Teams;
use app\models\Parser;

class ParserModelTest extends \Codeception\Test\Unit
{
    public function testParse()
    {
        $team = new Teams();
        $team->url = 'https://www.hltv.org/stats/teams/4608/Natus%20Vincere';
        $result = Parser::parse($team);
        $this->assertTrue(!is_null($result));
        $this->assertTrue($result->maps_played >= 1277);
        $this->assertTrue($result->total_kills >= 118291);
        $this->assertTrue($result->total_death >= 111101);
        $this->assertTrue($result->rounds_played >= 33647);
        $this->assertCount(4, $result->players);
    }
}
