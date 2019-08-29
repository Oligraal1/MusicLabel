<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\DateMatching\Datematch;
use App\entity\Event;
use \DateTime;


class DatematchTest extends TestCase 
{
    private $dm;
    /**
     * @dataProvider dateProvider
     *
     * @return void
     */
    public function testIsPast(Event $d, bool $truth)
    {
        
        $result=$this->dm->isPast($d);
        $this->assertEquals($truth, $result);
    }
    public function dateProvider()
    {
        $d1 = new Event();
        $d1->setDateStart(new \DateTime('2019-12-24'));
        $d2 = new Event();
        $d2->setDateStart(new \DateTime('1975-04-20'));

        return ['date-1' => [$d1, false], [$d2, true]];
    }
    public function setUp()
    {
        $this->dm = new Datematch();
    }
    function tearDown()
    {
        $this->dm=null;
    }
}
