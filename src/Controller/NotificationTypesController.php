<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\NotificationTypes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/notification_types", methods={"GET"}, name="notification_types_")
 */
class NotificationTypesController extends AbstractController
{
    /**
     * @Route("/", name="all")
     */
    public function index()
    {
        $notificationTypes = $this->getDoctrine()->getRepository(NotificationTypes::class)
        ->findAll();

        $response = [];
        foreach($notificationTypes as $type) {
            array_push($response, [
                'id' => $type->getId(),
                'name' => $type->getName()
            ]);
        }

        return $this->json($response, 200);
    }

    /**
     * @Route("/{id}", name="byId")
     */
    public function show($id)
    {
        $costType = $this->getDoctrine()->getRepository(NotificationTypes::class)
        ->find($id);

        if(!$costType) return $this->json(['message' => 'No notification type with this ID'], 400);

        $response = [
            'id' => $costType->getId(),
            'name' => $costType->getName()
        ];

        return $this->json($response, 200);
    }
}
