<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Gold;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contact")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/", name="contact_index", methods={"GET"})
     */
    public function index(ContactRepository $contactRepository): Response
    {
        return $this->render('contact/index.html.twig', ['contacts' => $contactRepository->findAll()]);
    }

    /**
     * @Route("/new", name="contact_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            
            $goldRep = $this->getDoctrine()->getRepository(Gold::class);

            if(null == $goldRep->findOneBy(['email' => $contact->getEmail()])) {
                $gold = new Gold();
                $gold->setEmail($contact->getEmail());
                $gold->setQuantity(20);
                $entityManager->persist($gold);
            } else {
                $gold = $goldRep->findOneBy(['email' => $contact->getEmail()]);
                $gold->addQuantity(10);
            }

            $entityManager->flush();
            
            return $this->redirectToRoute('contact_index');
        }

        return $this->render('contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contact_show", methods={"GET"})
     */
    public function show(Contact $contact, ContactRepository $contactRepository): Response
    {

        $nbEvent=$contactRepository->countEventByPerson ($contact->getEmail ());
        $nbNewContact=$contactRepository->countNewContactByPerson ($contact->getEmail ());
        $gold = $this->getDoctrine()->getRepository(Gold::class)->findOneBy(['email' => $contact->getEmail()]);
      
        return $this->render('contact/show.html.twig', [
            'contact' => $contact,
            'nbEvent'=>$nbEvent,
            'nbNewContact'=>$nbNewContact,
            'gold' => $gold

        ]);

    }

    /**
     * @Route("/{id}/edit", name="contact_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Contact $contact): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contact_index', ['id' => $contact->getId()]);
        }

        return $this->render('contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contact_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Contact $contact): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contact_index');
    }
}
