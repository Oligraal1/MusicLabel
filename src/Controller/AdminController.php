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

/**
 * @Route("/admin")
 */

class AdminController extends AbstractController {

    /**
     * @Route("/", name="admin_index")
     */
    public function index() {
        return $this->render('admin/index.html.twig', ['mainNavAdmin' => true, 'title' => 'Espace Admin']);
    }

}