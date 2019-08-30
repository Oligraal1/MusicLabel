<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testSomething()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/fr/home');

        //$this->assertResponseIsSuccessful();
        $h2 = $crawler->filter('h2');
        $this->assertCount(1, $h2);
        $this->assertContains('Bienvenue sur My Music Label', $h2->first()->text(), $h2->first()->text());
        
        $a= $crawler->filter('#linkEvent');
        $this->assertCount(1, $a);
        
            $this->assertContains('Les événements à venir', $a->text());
    
        
        $link = $crawler->selectLink('Les événements à venir')->link();
        $crawler = $client->click($link);

        $this->assertSame('Les événements à venir', $a->text());
       

    }
}
