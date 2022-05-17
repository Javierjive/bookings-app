<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Guest
 * @ORM\Table(name="guests")
 * @ORM\Entity
 */
class Guest
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255, nullable=false)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="dni", type="string", length=9, nullable=false)
     * @Assert\NotBlank(message="DNI is mandatory")
     * @Assert\Length(min=9, max=9, maxMessage="DNI format is not valid", minMessage="DNI format is not valid")
     */
    private $dni;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="phone_1", type="integer", nullable=false)
     */
    private $phone1;

    /**
     * @var int|null
     *
     * @ORM\Column(name="int_call_code_1", type="integer", nullable=true)
     */
    private $intCallCode1;

    /**
     * @var int|null
     *
     * @ORM\Column(name="phone_2", type="integer", nullable=true)
     */
    private $phone2;

    /**
     * @var int|null
     *
     * @ORM\Column(name="int_call_code_2", type="integer", nullable=true)
     */
    private $intCallCode2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="country", type="string", length=50, nullable=true)
     */
    private $country;

    /**
     * @var string|null
     *
     * @ORM\Column(name="city", type="text", length=65535, nullable=true)
     */
    private $city;

    /**
     * @var int|null
     *
     * @ORM\Column(name="postal_code", type="integer", nullable=true)
     */
    private $postalCode;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="birthday", type="date", nullable=true)
     */
    private $birthday;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdAt = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $updatedAt = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    public function getId(): ?string
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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(string $dni): self
    {
        $this->dni = $dni;

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

    public function getPhone1(): ?int
    {
        return $this->phone1;
    }

    public function setPhone1(int $phone1): self
    {
        $this->phone1 = $phone1;

        return $this;
    }

    public function getIntCallCode1(): ?int
    {
        return $this->intCallCode1;
    }

    public function setIntCallCode1(?int $intCallCode1): self
    {
        $this->intCallCode1 = $intCallCode1;

        return $this;
    }

    public function getPhone2(): ?int
    {
        return $this->phone2;
    }

    public function setPhone2(?int $phone2): self
    {
        $this->phone2 = $phone2;

        return $this;
    }

    public function getIntCallCode2(): ?int
    {
        return $this->intCallCode2;
    }

    public function setIntCallCode2(?int $intCallCode2): self
    {
        $this->intCallCode2 = $intCallCode2;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postalCode;
    }

    public function setPostalCode(?int $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function checkIfAlreadyExists($entityManager)
    {
        $duplicated_guests = $entityManager->createQueryBuilder()->select('g')->from('App\Entity\Guest', 'g')
            ->where('g.dni = :dni')
            ->orWhere('g.phone1 = :phone1')
            ->orWhere('g.email = :email')
            ->setParameters([
                ':dni'    => $this->getDni(),
                ':phone1' => $this->getPhone1(),
                ':email'  => $this->getEmail()
            ])
            ->getQuery()->getResult();

        if (count($duplicated_guests) > 0) {
            return $duplicated_guests[0];
        }

        return false;
    }


}
