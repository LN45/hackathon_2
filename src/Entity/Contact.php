<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 */
class Contact
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
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Event", inversedBy="contacts", cascade={"persist"})
     */
    private $event;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\SatisfactionQuizz", inversedBy="contacts")
     */
    private $satisfactionQuizz;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company", inversedBy="contacts")
     */
    private $company;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasResponse = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }
    
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        
        return $this;
    }
    
        public function getLastName(): ?string
        {
            return $this->lastName;
        }
    
        public function setLastName(string $lastName): self
        {
            $this->lastName = $lastName;
    
            return $this;
        }
    
        public function getEmail(): ?string
        {
            return $this->email;
        }
    
        public function setEmail(string $email): self
        {
            $this->email = $email;
    
            return $this;
        }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getSatisfactionQuizz(): ?SatisfactionQuizz
    {
        return $this->satisfactionQuizz;
    }

    public function setSatisfactionQuizz(?SatisfactionQuizz $satisfactionQuizz): self
    {
        $this->satisfactionQuizz = $satisfactionQuizz;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getHasResponse(): ?bool
    {
        return $this->hasResponse;
    }

    public function setHasResponse(bool $hasResponse): self
    {
        $this->hasResponse = $hasResponse;

        return $this;
    }
}
