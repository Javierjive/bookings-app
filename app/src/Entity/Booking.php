<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Booking
 *
 * @ORM\Table(name="bookings", indexes={@ORM\Index(name="guest_id", columns={"currency_id", "tax_id", "room_id"}), @ORM\Index(name="room_id", columns={"room_id"}), @ORM\Index(name="taxes_id", columns={"tax_id"}), @ORM\Index(name="IDX_7A853C3538248176", columns={"currency_id"})})
 * @ORM\Entity
 * @UniqueEntity("pid")
 */

class Booking
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
     * @ORM\Column(name="pid", type="string", length=250, nullable=false, unique=true)
     */
    private $pid;

    /**
     * @var int
     *
     * @ORM\Column(name="n_guests", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $nGuests;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $price;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_check_in", type="datetime", nullable=false)
     */
    private $dateCheckIn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_check_out", type="datetime", nullable=false)
     */
    private $dateCheckOut;

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

    /**
     * @var \Tax
     *
     * @ORM\ManyToOne(targetEntity="Tax")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tax_id", referencedColumnName="id")
     * })
     */
    private $tax;

    /**
     * @var \Currency
     *
     * @ORM\ManyToOne(targetEntity="Currency")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="currency_id", referencedColumnName="id")
     * })
     */
    private $currency;

    /**
     * @var \Room
     *
     * @ORM\ManyToOne(targetEntity="Room")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="room_id", referencedColumnName="id")
     * })
     */
    private $room;

    /**
     * @var int
     *
     * @ORM\Column(name="room_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $roomId;


    public function getId(): ?string
    {
        return $this->id;
    }

    public function getRoomId(): int
    {
        return $this->roomId;
    }

    public function getPid(): ?string
    {
        return $this->pid;
    }

    public function setPid(string $pid): self
    {
        $this->pid = $pid;

        return $this;
    }

    public function getNGuests(): ?int
    {
        return $this->nGuests;
    }

    public function setNGuests(int $nGuests): self
    {
        $this->nGuests = $nGuests;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDateCheckIn(): ?\DateTimeInterface
    {
        return $this->dateCheckIn;
    }

    public function setDateCheckIn(\DateTimeInterface $dateCheckIn): self
    {
        $this->dateCheckIn = $dateCheckIn;

        return $this;
    }

    public function getDateCheckOut(): ?\DateTimeInterface
    {
        return $this->dateCheckOut;
    }

    public function setDateCheckOut(\DateTimeInterface $dateCheckOut): self
    {
        $this->dateCheckOut = $dateCheckOut;

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

    public function getTax(): ?Tax
    {
        return $this->tax;
    }

    public function setTax(?Tax $tax): self
    {
        $this->tax = $tax;

        return $this;
    }

    public function getCurrency(): ?Currency
    {
        return $this->currency;
    }

    public function setCurrency(?Currency $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): self
    {
        $this->room = $room;

        return $this;
    }

    public function setRoomId(int $id): self
    {
        $this->$id = $this->roomId;

        return $this;
    }


}
