<?php

namespace App\Tests\EventRepository;


use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Repository\EventRepository;
use App\Entity\Event;




class EventRepositoryTest extends KernelTestCase
{
    /**
 * @var \Doctrine\ORM\EntityManager;
 */
    private $entityManager;


    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        $kernel = self::boothKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }
    /**
     * TestRequestCity
     *
     * @return void
     */
    public function TestRequestCity()
    {
        $event = $this->entityManager
            ->getRepository(Event::class)->requestCity('Paris');
        $this->assertEquals($event);
    }
    
}
