<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;
use App\Service\MailService;
use App\Entity\Event;

class MailController extends AbstractController
{
    /**
     * @Route("/mail/{event}", name="mail")
     */
    public function index(Event $event, \Swift_Mailer $mailer)
    {

        $contacts = $this->getDoctrine()->getRepository(Contact::class)->findBy(['event'=>$event]);
        /* $choiceEvent = $this->getDoctrine()->getRepository(Event::class)->findBy(['id'=>$event]); */

        foreach($contacts as $contact) {
           
            if(!$contact->getHasResponse()) {

                $message = (new \Swift_Message('Hello ' . $contact->getFirstName()))
                ->setFrom('hackaton2.lcc@gmail.com')
                ->setTo($contact->getEmail())
                ->setBody(
                    $this->renderView(
                        // templates/emails/registration.html.twig
                        'mail/index.html.twig',
                        array('contact' => $contact, 'event' => $event)
                    ),
                    'text/html'
                )
            ;
            $mailer->send($message);
            }
        
    
    

        }

       

    return $this->redirectToRoute("event_index");
    }
}
