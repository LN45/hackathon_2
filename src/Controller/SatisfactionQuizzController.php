<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Event;
use App\Entity\Gold;
use App\Entity\SatisfactionQuizz;
use App\Form\SatisfactionQuizzType;
use App\Repository\SatisfactionQuizzRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/satisfaction/quizz")
 */
class SatisfactionQuizzController extends AbstractController
{
    /**
     * @Route("/", name="satisfaction_quizz_index", methods={"GET"})
     */
    public function index(SatisfactionQuizzRepository $satisfactionQuizzRepository): Response
    {
        return $this->render('satisfaction_quizz/index.html.twig', ['satisfaction_quizzs' => $satisfactionQuizzRepository->findAll()]);
    }

    /**
     * @Route("/{event}/new", name="satisfaction_quizz_new", methods={"GET","POST"})
     */
    public function new(Request $request, Event $event): Response
    {

        $satisfactionQuizz = new SatisfactionQuizz();
        $form = $this->createForm(SatisfactionQuizzType::class, $satisfactionQuizz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $satisfactionQuizz->setEvent ($event);
            $entityManager->persist($satisfactionQuizz);
            $entityManager->flush();

            return $this->redirectToRoute('event_index');
        }

        return $this->render('satisfaction_quizz/new.html.twig', [
            'satisfaction_quizz' => $satisfactionQuizz,
            'form' => $form->createView(),
            'event' =>$event
        ]);
    }
    /**
     * @Route("/response/{event}/{contact}", name="satisfaction_quizz_response", methods={"GET","POST"})
     */
    public function quizzResponse(Request $request, Event $event, Contact $contact): Response
    {

        $satisfactionQuizz = new SatisfactionQuizz();
        $form = $this->createForm(SatisfactionQuizzType::class, $satisfactionQuizz);
        $form->handleRequest($request);

        if(!$contact->getHasResponse()) {
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $satisfactionQuizz->setEvent($event);
                $satisfactionQuizz->setEmail($contact->getEmail());
                $contact->setHasResponse(true);
                $gold = $this->getDoctrine()->getRepository(Gold::class)->findOneBy(['email' => $contact->getEmail()]);
                $gold->addQuantity(20);
                $entityManager->persist($satisfactionQuizz);
                $entityManager->flush();
    
                $this->addFlash(
                    'success',
                    'Formulaire validé !'
                );
                return $this->redirectToRoute('event_index');
            }
        } else {
            $this->addFlash(
                'danger',
                'Formulaire déja rempli !'
            );
            return $this->redirectToRoute('event_index');
        }

        return $this->render('satisfaction_quizz/response.html.twig', [
            'satisfaction_quizz' => $satisfactionQuizz,
            'form' => $form->createView(),
            'event'=>$event
        ]);
    }

    /**
     * @Route("/{id}", name="satisfaction_quizz_show", methods={"GET"})
     */
    public function show(SatisfactionQuizz $satisfactionQuizz): Response
    {
        return $this->render('satisfaction_quizz/show.html.twig', ['satisfaction_quizz' => $satisfactionQuizz]);
    }

    /**
     * @Route("/{id}/edit", name="satisfaction_quizz_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SatisfactionQuizz $satisfactionQuizz): Response
    {
        $form = $this->createForm(SatisfactionQuizzType::class, $satisfactionQuizz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('satisfaction_quizz_index', ['id' => $satisfactionQuizz->getId()]);
        }

        return $this->render('satisfaction_quizz/edit.html.twig', [
            'satisfaction_quizz' => $satisfactionQuizz,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="satisfaction_quizz_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SatisfactionQuizz $satisfactionQuizz): Response
    {
        if ($this->isCsrfTokenValid('delete'.$satisfactionQuizz->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($satisfactionQuizz);
            $entityManager->flush();
        }

        return $this->redirectToRoute('satisfaction_quizz_index');
    }
}
