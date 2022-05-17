<?php

namespace App\Repository;

use App\Entity\Booking;
use App\Utils\Utils;
use Doctrine\ORM\EntityManagerInterface;

class BookingsRepository
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entity_manager)
    {
        $this->entity_manager = $entity_manager;
    }


    /**
     * @param string $date_check_in
     * @param string $date_check_out
     * @return array|null
     */
    public function getActiveBookings(string $date_check_in = '', string $date_check_out = ''): ?array
    {
        $qb = $this->entity_manager->createQueryBuilder();
        $qb->select('b')
            ->from('App:Booking', 'b')
            ->leftJoin('b.room', 'r')
            ->Where('b.dateCheckOut >= :current_date');

        if (!empty($date_check_in) && !empty($date_check_out)) {
            $qb->andWhere('b.dateCheckOut >= :date_check_out AND b.dateCheckIn <= :date_check_in')
                ->orWhere('b.dateCheckIn >= :date_check_in AND b.dateCheckIn <= :date_check_out AND b.dateCheckOut >= :date_check_out')
                ->orWhere('b.dateCheckIn <= :date_check_in AND b.dateCheckOut >= :date_check_in AND b.dateCheckOut <= :date_check_out');

            $qb->setParameters(['date_check_in' => $date_check_in, 'date_check_out' => $date_check_out, ':current_date' => Utils::FormatDateTime(date('Y-m-d'))]);
        } else {
            $qb->setParameter(':current_date', Utils::FormatDateTime(date('Y-m-d')));
        }


        try {
            $active_bookings = $qb->getQuery()->getResult();
        } catch (Exception $e) {
            $active_bookings = [
                "error" => 1,
                "message" => "Internal server error: " + $e->getMessage()
            ];
        }

        return $active_bookings;
    }

    private function getRoomFromActiveBookings(array $active_bookings) : array
    {
        $reserved_rooms_id = [];
        foreach ($active_bookings as $item) {
            $reserved_rooms_id[] = $item->getRoomId();
        }

        return $reserved_rooms_id;
    }


    /**
     * @param string $date_check_in
     * @param string $date_check_out
     * @param int $n_guests
     * @return array
     */
    public function getFreeRooms(string $date_check_in, string $date_check_out, int $n_guests): array
    {
        $active_bookings = $this->getActiveBookings($date_check_in, $date_check_out);
        $reserved_rooms_id_str = implode(',', $this->getRoomFromActiveBookings($active_bookings));

        $qb = $this->entity_manager->createQueryBuilder();

        $qb->select('r')->from('App:Room', 'r')->where($qb->expr()->notIn('r.id', ':reserved_rooms_id'))->andWhere('r.availability = :available')->andWhere('r.type >= :room_type');
        $qb->setParameters([':reserved_rooms_id' => $reserved_rooms_id_str ,':available' => '1', ':room_type' => $n_guests]);
        $free_rooms = $qb->getQuery()->getResult();

        $free_rooms_array_format = [];
        if (!empty($free_rooms)) {
            foreach ($free_rooms as $free_room) {
                $free_room_id = $free_room->getId();
                $free_rooms_array_format["$free_room_id"] = $free_room;
            }
        }

        return $free_rooms_array_format;
    }

    public function getActiveBookingsWithGuest(string $date_check_in = '', string $date_check_out = '')
    {
        $qb = $this->entity_manager->createQueryBuilder();
        $qb->select('g.name as guest_name, g.surname as guest_surname, g.dni as guest_dni, g.email as guest_email, g.intCallCode1 as guest_int_call_code_1, g.phone1 as guest_phone_1,
                            b.dateCheckIn as date_checkin, b.dateCheckOut as date_checkout, b.nGuests as n_guest, b.price,
                            r.number as room_number, r.type as room_type, r.name as room_name')
            ->from('App:GuestBooking', 'gb')
            ->innerJoin('gb.guest', 'g')
            ->innerJoin('gb.booking', 'b')
            ->innerJoin('gb.room', 'r')
            ->Where('b.dateCheckOut >= :current_date');

        $qb->setParameter(':current_date', Utils::FormatDateTime(date('Y-m-d')));

        try {
            $active_bookings_with_guests = $qb->getQuery()->getResult();
        } catch (Exception $e) {
            $active_bookings_with_guests = [
                "error" => 1,
                "message" => "Internal server error: " + $e->getMessage()
            ];
        }

        return $active_bookings_with_guests;
    }
}