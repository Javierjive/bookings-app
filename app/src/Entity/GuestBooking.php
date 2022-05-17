<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GuestBooking
 *
 * @ORM\Table(name="guests_bookings", indexes={@ORM\Index(name="booking_id", columns={"booking_id"}), @ORM\Index(name="guest_id", columns={"guest_id", "booking_id"}), @ORM\Index(name="room_id", columns={"room_id"}), @ORM\Index(name="IDX_C1E1DC6E9A4AA658", columns={"guest_id"})})
 * @ORM\Entity
 */
class GuestBooking
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
     * @var \Guest
     *
     * @ORM\ManyToOne(targetEntity="Guest")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="guest_id", referencedColumnName="id")
     * })
     */
    private $guest;

    /**
     * @var \Booking
     *
     * @ORM\ManyToOne(targetEntity="Booking")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="booking_id", referencedColumnName="id")
     * })
     */
    private $booking;

    /**
     * @var \Room
     *
     * @ORM\ManyToOne(targetEntity="Room")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="room_id", referencedColumnName="id")
     * })
     */
    private $room;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getGuest(): ?Guest
    {
        return $this->guest;
    }

    public function setGuest(?Guest $guest): self
    {
        $this->guest = $guest;

        return $this;
    }

    public function getBooking(): ?Booking
    {
        return $this->booking;
    }

    public function setBooking(?Booking $booking): self
    {
        $this->booking = $booking;

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


}
