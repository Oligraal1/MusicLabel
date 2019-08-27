<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Evenemt\RegisterEvent;
use App\Evenemt\RegisterListener;
use App\Form\MemberType;
use App\Form\RegistrationFormType;
use App\Security\AppUserAuthAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

/** @Route("/member") */
class MemberController extends AbstractController {
     /**
     * @Route("/", name="member_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        $id=$this->getUser()->getId();
        
        return $this->render('member/index.html.twig', [
            'id' => $id,
        ]);
    }
    /**
     * @Route("/{id}", name="member_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('member/show.html.twig', [
            'member' => $user,
        ]);
    }
    /**
     * @Route("/{id}/edit", name="member_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user ):Response 
    {
         
        $form = $this->createForm(MemberType::class, $user);
        $form->handleRequest($request);
        
            if ($form->isSubmitted() && $form->isValid()) 
            {
                $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Changement validé ! Knowledge is power!');
                return $this->redirectToRoute('member_index');

            }
            
            return $this->render('member/edit.html.twig',
            [
                'member' => $user,
                'formMember' => $form->createView(),
                'mainNavMember'=>true, 
                'title'=>'Espace Membre',
            ]);
    }
     /**
     * @Route("/{id}", name="member_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('member_index');
    }

}