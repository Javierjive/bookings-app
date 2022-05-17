<?php

namespace App\Controller;


use App\Entity\Booking;
use App\Entity\Guest;
use App\Entity\GuestBooking;
use App\Repository\BookingsRepository;
use App\Utils\Uitls;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;
use App\Utils\Utils;
use Symfony\Component\Validator\Validator\ValidatorInterface;



class BookingController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator =  $validator;
    }
    
    public function newReserv(): Response
    {
        return $this->render('bookings/new_reserv.twig', []);
    }

    public function list(): Response
    {
        $bookings_repository = new BookingsRepository($this->entityManager);
        $bookigns = $bookings_repository->getActiveBookingsWithGuest();

        return $this->render('bookings/bookings.html.twig', ['bookings' => $bookigns]);
    }

    public function getFreeRooms(ManagerRegistry $doctrine, Request $request)
    {   
        $parameters = json_decode($request->getContent());
        
        
        $date_check_in = $parameters->date_checkin;
        $date_check_out = $parameters->date_checkout;
        $n_guest = $parameters->n_guests;

        $deadline = date('2022-12-31');
        if (date($date_check_out) > $deadline) {
            return $this->json([
                'error' => 1,
                'message' => "Sorry, reservations with checkout after $deadline are not accepted. You can contact with admin people"
            ]);
        };

        $bookings_repository = new BookingsRepository($this->entityManager);
        $free_rooms = $bookings_repository->getFreeRooms($date_check_in, $date_check_out, $n_guest);
        
        //$bookings = $doctrine->getRepository(Booking::class)->find(2);

        return $this->json([
            'error' => 0,
            "data" => $free_rooms
        ]);
    }

    public function saveReserv(ManagerRegistry $doctrine, Request $request)
    {
        // Get params
        $parameters = json_decode($request->getContent());

        // Save Booking
        $tax = $this->entityManager->find('App\Entity\Tax', 1);
        $currency = $this->entityManager->find('App\Entity\Currency', 1);
        $room = $this->entityManager->find('App\Entity\Room', $parameters->room->id);

        $booking = new Booking();
        $date_checkin = Utils::FormatDateTime($parameters->date_checkin);
        $date_checkout = Utils::FormatDateTime($parameters->date_checkout);
        $createdAt = Utils::FormatDateTime(date("Y-m-d H:i:s"));
        $updatedAt = Utils::FormatDateTime(date("Y-m-d H:i:s"));


        // Booking
        $pid = Uuid::v1();
        $booking->setDateCheckIn($date_checkin);
        $booking->setDateCheckOut($date_checkout);
        $booking->setNGuests($parameters->n_guests);
        $booking->setUpdatedAt($updatedAt);
        $booking->setCreatedAt($createdAt);
        $booking->setPid($pid->toRfc4122());
        $booking->setPrice($parameters->total_price);
        $booking->setTax($tax);
        $booking->setCurrency($currency);
        $booking->setRoom($room);

        $this->entityManager->persist($booking);

        // Save guest
        $guest = new Guest();

        $guest->setDni($parameters->guest_dni);
        $guest->setPhone1((int)$parameters->guest_phone_1);
        $guest->setEmail($parameters->guest_email);

        $existingGuest = $guest->checkIfAlreadyExists($this->entityManager);
        if ($existingGuest) {
            $guest = $existingGuest;
        } else {
            $guest->setName($parameters->guest_name);
            $guest->setSurName($parameters->guest_surname);

            $guest->setIntCallCode1($parameters->guest_int_call_code_1);

            if (!empty($parameters->guest_int_call_code_2)) {
                $guest->setIntCallCode2($parameters->guest_int_call_code_2);
            }
            if (!empty($parameters->guest_phone_2)) {
                $guest->setPhone2((int)$parameters->guest_phone_2);
            }

            $created_at = Utils::FormatDateTime(date("Y-m-d H:i:s"));
            $updatedAt = Utils::FormatDateTime(date("Y-m-d H:i:s"));
            $guest->setCreatedAt($created_at);
            $guest->setUpdatedAt($updatedAt);
            $this->entityManager->persist($guest);
        }

        $guestBooking = new GuestBooking();
        $guestBooking->setGuest($guest);
        $guestBooking->setBooking($booking);
        $guestBooking->setRoom($room);
        $this->entityManager->persist($guestBooking);



        $errors = $this->validator->validate($guest);

        if (count($errors) > 0) {
            $out = [
                'error'   => 1,
                'message' => 'Error to save booking, please check the form or contact with Admin people'
            ];
        } else {
            try {
                $this->entityManager->flush();
                $out = [
                    'error' => 0,
                    'message' => 'Booking has been saved successfully!'
                ];
            } catch (\Exception $e) {
                $out = [
                    'error'   => 1,
                    'message' => 'Error to save booking, please check the form or contact with Admin people'
                ];
            }
        }

        return $this->json($out);
    }


}
