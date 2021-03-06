<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Entity\User;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/event")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="event_index", methods={"GET"})
     */
    public function index(EventRepository $eventRepository, TranslatorInterface $translator): Response
    {   
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
       
        $cityUser=$this->getUser()->getVille();
       
        $cities = $this->getDoctrine()
                         ->getManager()
                         ->getRepository(Event::class)
                         ->requestCity($cityUser);
        $NbCities = $this->getDoctrine()
                         ->getManager()
                         ->getRepository(Event::class)
                         ->getNbEventinCity($cityUser);
        
        $messageEvents = $translator->trans('num_of_event', ['NbCities' => $NbCities]);
        return $this->render('event/index.html.twig', [
            'events' => $eventRepository->findAll(), 
            'city'=> $cities,
            'NbCities'=>$NbCities,
            'messageEvents' => $messageEvents
        ]);
        }
        return $this->render('event/index.html.twig', [
            'events' => $eventRepository->findAll(), 
           // 'city'=> $cities,
            // 'NbCities'=>$NbCities,
            // 'messageEvents' => $messageEvents
        ]);

    }

    /**
     * @Route("/new", name="event_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('event_index');
        }

        return $this->render('event/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="event_show", methods={"GET"})
     */
    public function show(Event $event, \App\Local\Localisation $h): Response
    {
      
        return $this->render('event/show.html.twig', [
            'event' => $event,
            'ville'=> $h->oneCity($event->getVille()),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="event_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Event $event): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_index');
        }

        return $this->render('event/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="event_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Event $event): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('event_index');
    }

    
}
