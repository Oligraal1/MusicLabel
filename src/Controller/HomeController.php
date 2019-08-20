<?php

namespace App\Controller;

use App\Entity\Artiste;
use App\Repository\ArtisteRepository;
use App\Entity\Event;
use App\Entity\Actualite;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\NotBlank;
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
        
        $reposi = $em->getRepository(Actualite::class);
        $actualites=$reposi->findAll();
        
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            "artiste" => $artistes, 'events'=>$events,
            'actualites'=>$actualites,
        ]);

    }
    public function selectOption(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('artiste', EntityType::class, [
                'required' => false,
                'placeholder' => '--- Select ---',
                'class' => Artiste::class,
                'choice_label' => function (Artiste $artiste) {
                    return sprintf(
                        '%s, %s',
                        $artiste->getNom()
                    );
                },
                'constraints' => [
                    new NotBlank()
                ],
            ])
            ->getForm()
            ->handleRequest($request)
        ;

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var $selected Artiste */
            $selected = $form->get('artiste')->getData();
            dump($selected);
        }

        return $this->render('home/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
    



