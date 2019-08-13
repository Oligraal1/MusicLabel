<?php

namespace App\Controller;

use App\Entity\CommandLigne;
use App\Form\CommandLigneType;
use App\Repository\CommandLigneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/command/ligne")
 */
class CommandLigneController extends AbstractController
{
    /**
     * @Route("/", name="command_ligne_index", methods={"GET"})
     */
    public function index(CommandLigneRepository $commandLigneRepository): Response
    {
        return $this->render('command_ligne/index.html.twig', [
            'command_lignes' => $commandLigneRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="command_ligne_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $commandLigne = new CommandLigne();
        $form = $this->createForm(CommandLigneType::class, $commandLigne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commandLigne);
            $entityManager->flush();

            return $this->redirectToRoute('command_ligne_index');
        }

        return $this->render('command_ligne/new.html.twig', [
            'command_ligne' => $commandLigne,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="command_ligne_show", methods={"GET"})
     */
    public function show(CommandLigne $commandLigne): Response
    {
        return $this->render('command_ligne/show.html.twig', [
            'command_ligne' => $commandLigne,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="command_ligne_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CommandLigne $commandLigne): Response
    {
        $form = $this->createForm(CommandLigneType::class, $commandLigne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('command_ligne_index');
        }

        return $this->render('command_ligne/edit.html.twig', [
            'command_ligne' => $commandLigne,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="command_ligne_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CommandLigne $commandLigne): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commandLigne->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commandLigne);
            $entityManager->flush();
        }

        return $this->redirectToRoute('command_ligne_index');
    }
}
