<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Notification;
use App\Entity\NotificationTypes;
use App\Entity\Car;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/notification", name="notification_")
 */
class NotificationController extends AbstractController
{
    /**
     * @Route("/", methods={"GET", "POST"}, name="showAll")
     */
    public function index(Request $request)
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'No logged in'], 400);

        $data = json_decode($request->getContent(), true);

        if(isset($data['idCar'])) $notificationList = $this->getDoctrine()->getRepository(Notification::class)->findByIdcar($data['idCar']);
        else $notificationList = $this->getDoctrine()->getRepository(Notification::class)->findByIduser($_SESSION['idUser']);
        if(!$notificationList) return $this->json(['message' => 'No active notification'], 200);

        $response = [];
        foreach($notificationList as $notification) {
            array_push($response, [
                'id' => $notification->getId(),
                'idCar' => $notification->getIdcar()->getId(),
                'carName' => $notification->getIdcar()->getName(),
                'notificationType' => $notification->getIdnotificationtype()->getName(),
                'description' => $notification->getDescription(),
                'notificationDate' => $notification->getNotificationdate()->format('Y-m-d'),
                'status' => $notification->getStatus()
            ]);
        }
        return $this->json($response, 200);
    }

    /**
     * @Route("/recent", methods={"GET"}, name="showWeekRecent")
     */
    public function getRecent()
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'No logged in'], 400);

        $today = new \DateTime("now");
        $date = new \DateTime("now");
        $date->modify('+1week');

        $notificationList = $this->getDoctrine()->getRepository(Notification::class)->findBy(array('iduser' => $_SESSION['idUser'], 'status' => 1));
        $response = [];
        foreach($notificationList as $notification) {
            $notificationDate = $notification->getNotificationdate();
            $interval = date_diff($today, $notificationDate);

            // koniec testow daty

            if($interval->format('%R%a') <= 7 ) {
                array_push($response, [
                    'id' => $notification->getId(),
                    'idCar' => $notification->getIdcar()->getId(),
                    'carName' => $notification->getIdcar()->getName(),
                    'notificationType' => $notification->getIdnotificationtype()->getName(),
                    'description' => $notification->getDescription(),
                    'notificationDate' => $notification->getNotificationdate()->format('Y-m-d'),
                    'status' => $notification->getStatus()
                ]);
            }
        }

        return $this->json($response, 200);
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="showById")
     */
    public function show(int $id)
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'No logged in'], 400);
        
        $notification = $this->getDoctrine()->getRepository(Notification::class)
        ->find($id);
        if(!$notification) return $this->json(['message' => 'No active notification'], 200);
        if($notification->getIduser()->getId() != $_SESSION['idUser']) return $this->json(['message' => 'No access to notification'], 400);

        $response = [
            'id' => $notification->getId(),
            'idCar' => $notification->getIdcar()->getId(),
            'carName' => $notification->getIdcar()->getName(),
            'notificationType' => $notification->getIdnotificationtype()->getName(),
            'description' => $notification->getDescription(),
            'notificationDate' => $notification->getNotificationdate()->format('Y-m-d'),
            'status' => $notification->getStatus()
        ];

        return $this->json($response, 200);
    }

    /**
     * @Route("/create", methods={"POST"}, name="create")
     */
    public function create(Request $request)
    {
        session_start();
        $entityManager = $this->getDoctrine()->getManager();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'No logged in'], 400);
        
        $data = json_decode($request->getContent(), true);

        $car = $this->getDoctrine()->getRepository(Car::class)->find($data['idCar']);
        if(!$car || $car->getIduser()->getId() != $_SESSION['idUser']) return $this->json(['message' => 'No access']);

        $notificationType = $this->getDoctrine()->getRepository(NotificationTypes::class)->find($data['idNotificationType']);

        $user = $this->getDoctrine()->getRepository(User::class)->find($_SESSION['idUser']);
        $notification = new Notification();
        $notification->setIdcar($car)
            ->setIdnotificationtype($notificationType)
            ->setDescription($data['description'])
            ->setNotificationdate(new \DateTime($data['date']))
            ->setIduser($user)
            ->setStatus(1);

        $entityManager->persist($notification);
        $entityManager->flush();

        return $this->json(['message' => 'Notification added',
        'id' => $notification->getId()]);
    }

     /**
     * @Route("/{id}", methods={"DELETE"}, name="notification_delete")
     */
    public function delete($id)
    {
       session_start();

       if(isset($_SESSION['idUser'])) {
        $entityManager = $this->getDoctrine()->getManager();
        $notification = $this->getDoctrine()->getRepository(Notification::class)
         ->find($id);

        if(!$notification) return $this->json(['message' => 'No notification with this ID'], 400);
        if($notification->getIduser()->getId() != $_SESSION['idUser']) return $this->json(['message' => 'No access to notification'], 400);

         $entityManager->remove($notification);
         $entityManager->flush();

         return $this->json(['message' => 'Notification deleted'], 200);
       }

       return $this->json(['message' => 'You are not logged in'], 404);
    }
}
