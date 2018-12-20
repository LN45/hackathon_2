<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends AbstractController
{
    /**
     * @Route("/mail/{name}/{email}", name="mail")
     */
    public function index($name, $email, \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Hello Email'))
        ->setFrom('hackaton2.lcc@gmail.com')
        ->setTo($email)
        ->setBody(
            $this->renderView(
                // templates/emails/registration.html.twig
                'mail/index.html.twig',
                array('name' => $name)
            ),
            'text/html'
        )
    ;

    $mailer->send($message);

    return $this->redirectToRoute("event_index");
    }
}
