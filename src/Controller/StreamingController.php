<?php

namespace App\Controller;

use App\Entity\Streaming;
use App\Form\StreamingType;
use App\Repository\StreamingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/streaming")
 */
class StreamingController extends AbstractController
{
    /**
     * @Route("/", name="streaming_index", methods={"GET"})
     */
    public function index(StreamingRepository $streamingRepository): Response
    {
        return $this->render('streaming/index.html.twig', [
            'streamings' => $streamingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="streaming_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $streaming = new Streaming();
        $form = $this->createForm(StreamingType::class, $streaming);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($streaming);
            $entityManager->flush();

            return $this->redirectToRoute('streaming_index');
        }

        return $this->render('streaming/new.html.twig', [
            'streaming' => $streaming,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="streaming_show", methods={"GET"})
     */
    public function show(Streaming $streaming): Response
    {
        return $this->render('streaming/show.html.twig', [
            'streaming' => $streaming,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="streaming_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Streaming $streaming): Response
    {
        $form = $this->createForm(StreamingType::class, $streaming);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('streaming_index');
        }

        return $this->render('streaming/edit.html.twig', [
            'streaming' => $streaming,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="streaming_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Streaming $streaming): Response
    {
        if ($this->isCsrfTokenValid('delete'.$streaming->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($streaming);
            $entityManager->flush();
        }

        return $this->redirectToRoute('streaming_index');
    }
}
