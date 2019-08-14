<?php

namespace App\Controller;

use App\Entity\Artiste;
use App\Repository\ArtisteRepository;
use App\Entity\Event;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Artiste::class);
        $artistes = $repository-> findAll();
        $repo = $em->getRepository(Event::class);
        $events = $repo-> findAll();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            "artiste" => $artistes, 'events'=>$events,
        ]);

    }
    
    
}


