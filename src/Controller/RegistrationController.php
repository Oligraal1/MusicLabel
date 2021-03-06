<?php

namespace App\Controller;

use App\Entity\User;
use App\Evenemt\RegisterEvent;
use App\Evenemt\RegisterListener;
use App\Form\RegistrationFormType;
use App\Security\AppUserAuthAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;


class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, AppUserAuthAuthenticator $authenticator, EventDispatcherInterface $dispatcher, RegisterListener $listener): Response
    {
        $dispatcher->addListener(RegisterEvent::NAME, [$listener,'sendMailToUser']);
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
           // $this->addFlash('success', 'Vous êtes bien enregistré, Bienvenue');
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword
                (
                    $user,
                    $form->get('plainPassword')->getData()
                ));
            //on active par défaut
            $user->setIsActive(true);
            $user->setRoles(["ROLE_USER"]);
            if ($user->getEmail() == "demo@admin.fr") {
                $user->setRoles(['ROLE_SUPER_ADMIN']);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email
            $e = new RegisterEvent($user);
            $dispatcher->dispatch($e, RegisterEvent::NAME);
            
            return $guardHandler->authenticateUserAndHandleSuccess
            (
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }
        
        return $this->render('registration/register.html.twig', 
        [
            'registrationForm' => $form->createView(),
        ]);
    }
}
