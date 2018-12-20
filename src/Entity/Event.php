<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contact", mappedBy="event")
     */
    private $contacts;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\SatisfactionQuizz", mappedBy="event", cascade={"persist", "remove"})
     */
    private $satisfactionQuizz;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Contact[]
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->setEvent($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->contains($contact)) {
            $this->contacts->removeElement($contact);
            // set the owning side to null (unless already changed)
            if ($contact->getEvent() === $this) {
                $contact->setEvent(null);
            }
        }

        return $this;
    }

    public function getSatisfactionQuizz(): ?SatisfactionQuizz
    {
        return $this->satisfactionQuizz;
    }

    public function setSatisfactionQuizz(SatisfactionQuizz $satisfactionQuizz): self
    {
        $this->satisfactionQuizz = $satisfactionQuizz;

        // set the owning side of the relation if necessary
        if ($this !== $satisfactionQuizz->getEvent()) {
            $satisfactionQuizz->setEvent($this);
        }

        return $this;
    }
}
