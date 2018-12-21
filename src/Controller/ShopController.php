<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;
use App\Entity\Gold;

class ShopController extends AbstractController
{
    /**
     * @Route("/shop/{id}", name="shop")
     */
    public function index(Contact $contact)
    {

        $contactGold = $this->getDoctrine()->getRepository(Gold::class)->findOneBy(['email'=>$contact->getEmail()]);

        return $this->render('shop/index.html.twig', [
            'contact' => $contact,
            'gold' => $contactGold,
        ]);
    }

    /**
     * @Route("/shop/{contact}/buy/{price}", name="shop_buy")
     */
    public function buy(Contact $contact, int $price)
    {
        
        $contactGold = $this->getDoctrine()->getRepository(Gold::class)->findOneBy(['email'=>$contact->getEmail()]);
        
        if($contactGold->getQuantity()>=$price) {
            $contactGold->removeQuantity($price);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'success',
                'Achat effectué !'
            );
        } else {
            $this->addFlash(
                'danger',
                'Pas asser de Lab\'coins !'
            );
        }

        return $this->render('shop/index.html.twig', [ 'contact' => $contact ]);
    }
}
