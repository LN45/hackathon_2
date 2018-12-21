<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\SatisfactionQuizz;
use App\Form\EventType;
use App\Repository\ContactRepository;
use App\Repository\EventRepository;
use App\Repository\SatisfactionQuizzRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;

/**
 * @Route("/event")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="event_index", methods={"GET"})
     */
    public function index(EventRepository $eventRepository): Response
    {
//        $this->addFlash ('success', 'test');
        return $this->render('event/index.html.twig', ['events' => $eventRepository->findAll()]);
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
    public function show(Event $event, ContactRepository $contactRepository): Response
    {
        $average=$contactRepository->averageNotation($event->getId ());
      //  $average=array_sum($notes)/count($notes);

        $sumContact=$contactRepository->SumContactCreation ($event->getId ());
        $nbAnswer=$contactRepository->nbAnswer ($event->getId ());
        $countParticipant=$contactRepository->countParticipants ($event->getId ());
        if( $countParticipant['countParticipant'] != 0 ) {
            $participationRate = $nbAnswer['nbAnswer'] / $countParticipant['countParticipant'] * 100;
        } else {
            $participationRate = 0;
        }

        $contacts = $this->getDoctrine()->getRepository(Contact::class)->findBy(['event'=>$event]);

        return $this->render('event/show.html.twig', [
            'event' => $event,
            'contacts' => $contacts,
            'average'=>$average,
            'sumContact'=>$sumContact,
            'nbAnswer' =>$nbAnswer,
            'participationRate'=>$participationRate,

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

            $contacts = $this->getDoctrine()->getRepository(Contact::class)->findBy(['event'=>$event]);



            return $this->redirectToRoute('event_index', ['id' => $event->getId()]);
        }

        return $this->render('event/edit.html.twig', [
            'event' => $event,
            'contacts' => $event->getContacts(),
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
