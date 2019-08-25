<?php

namespace App\Evenemt;

use Twig\Environment;

class RegisterListener 
{
    private $mailer;
    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }
     public function sendMailToUser(RegisterEvent $e)
    {

        $transport = new \Swift_SmtpTransport();
        $mailer = new \Swift_Mailer($transport);

    $message = ( new \Swift_Message ( 'Hello Email' ))
        -> setFrom ( 'ocoffineau@gmail.com' )
        -> setTo ( $e->getUser()->getEmail() )
        -> setBody (
            $this -> renderer -> render (
                // templates/emails/registration.html.twig
                'emails/registration.html.twig'
            ),
            'text/html'
        );

        // you can remove the following code if you don't define a text version for your emails
    //     -> addPart (
    //         $this -> renderView (
    //             // templates/emails/registration.txt.twig
    //             'emails/registration.txt.twig' ,
    //             [ 'name' => $name ]
    //         ),
    //         'text/plain'
    //     )
    // ;

    $mailer -> send ( $message );

   // return $this -> render ( 'security/login.html.twig' );
}
    }
