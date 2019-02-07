<?php

namespace tests\unit\models;

use app\entities\Teams;
use app\models\CreateTeam;
use app\models\Parser;

class CreateModelTest extends \Codeception\Test\Unit
{
    public function testCreate()
    {
        $transaction = \Yii::$app->db->beginTransaction();
        $form = new CreateTeam();
        $form->url = 'https://www.hltv.org/stats/teams/4608/Natus%20Vincere';
        $this->assertTrue($form->create());
        $this->assertTrue($form->getEntity()->maps_played >= 1277);
        $this->assertTrue($form->getEntity()->total_kills >= 118291);
        $this->assertTrue($form->getEntity()->total_deaths >= 111101);
        $this->assertTrue($form->getEntity()->rounds_played >= 33647);
        $this->assertCount(4, $form->getEntity()->players);
        $transaction->rollBack();
    }
}
