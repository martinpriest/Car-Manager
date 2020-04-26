<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Notification;
use App\Entity\NotificationTypes;
use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/notification", name="notification_")
 */
class NotificationController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="showAll")
     */
    public function index()
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'No logged in'], 400);
        
        $notificationList = $this->getDoctrine()->getRepository(Notification::class)
        ->findByIduser($_SESSION['idUser']);
        if(!$notificationList) return $this->json(['message' => 'No active notification'], 400);

        $response = [];
        foreach($notificationList as $notification) {
            array_push($response, [
                'id' => $notification->getId(),
                'idCar' => $notification->getIdcar()->getId(),
                'notificationType' => $notification->getIdnotificationtype()->getName(),
                'description' => $notification->getDescription(),
                'notificationDate' => $notification->getNotificationdate(),
                'status' => $notification->getStatus()
            ]);
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
        if(!$notification) return $this->json(['message' => 'No active notification'], 400);
        if($notification->getIduser() != $_SESSION['idUser']) return $this->json(['message' => 'No access to notification'], 400);

        $response = [
            'id' => $notification->getId(),
            'idCar' => $notification->getIdcar()->getId(),
            'notificationType' => $notification->getIdnotificationtype()->getName(),
            'description' => $notification->getDescription(),
            'notificationDate' => $notification->getNotificationdate(),
            'status' => $notification->getStatus()
        ];

        return $this->json($response, 200);
    }

    /**
     * @Route("/{idCar}/{idNotificationType}/{description}/{date}", methods={"POST"}, name="create")
     */
    public function create($idCar, $idNotificationType, $description, $date)
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'No logged in'], 400);
        
        $car = $this->getDoctrine()->getRepository(Car::class)->find($idCar);
        $notificationType = $this->getDoctrine()->getRepository(NotificationTypes::class)->find($idNotificationType);
        if(!$car) return $this->json(['message' => 'No car with this ID'], 400);
        if($car->getIduser()->getId() != $_SESSION['idUser']) return $this->json(['message' => 'No access to this car'], 400);

        $entityManager = $this->getDoctrine()->getManager();
        $notification = new Notification();
        $notification->setIdcar($car)
            ->setIdnotificationtype($notificationType)
            ->setDescription($description)
            ->setNotificationdate(new \DateTime($date))
            ->setIduser($_SESSION['idUser'])
            ->setStatus(1);

        $entityManager->persist($notification);
        $entityManager->flush();

        return $this->json(['message' => 'Notification added'], 200);
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
        if($notification->getIduser() != $_SESSION['idUser']) return $this->json(['message' => 'No access to notification'], 400);

         $entityManager->remove($notification);
         $entityManager->flush();

         return $this->json(['message' => 'Notification deleted'], 200);
       }

       return $this->json(['message' => 'You are not logged in'], 404);
    }
}
