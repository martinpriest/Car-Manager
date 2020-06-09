<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\CarGroup;
use App\Entity\User;
use App\Entity\Car;

/**
 * @Route("/car_group", name="car_group_")
 */
class CarGroupController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="showAll")
     */
    public function index()
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'You have to login'], 400);

        $carGroups = $this->getDoctrine()->getRepository(CarGroup::class)
        ->findByIduser($_SESSION['idUser']);

        $response = [];
        foreach($carGroups as $carGroup) {
            array_push($response, [
                'id' => $carGroup->getId(),
                'name' => $carGroup->getName(),
                'menuPosition' => $carGroup->getMenuposition()
            ]);
        }

        return $this->json($response, 200);
    }

    /**
     * @Route("/{idCarGroup}", methods={"GET"}, name="showById")
     */
    public function show(int $idCarGroup)
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'You have to login'], 400);

        $carGroup = $this->getDoctrine()->getRepository(CarGroup::class)
        ->find($idCarGroup);
        if(!$carGroup) return $this->json(['message' => 'Car group not exist'], 400);
        if($carGroup->getIduser()->getId() != $_SESSION['idUser']) return $this->json(['message' => 'No access to car group'], 400);
        $response = [
            'id' => $carGroup->getId(),
            'name' => $carGroup->getName(),
            'menuPosition' => $carGroup->getMenuposition()
        ];

        return $this->json($response, 200);
    }

    /**
     * @Route("/", methods={"POST"}, name="create")
     */
    public function create(Request $request)
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'You have to login'], 400);
        $data = json_decode($request->getContent(), true);

        $user = $this->getDoctrine()->getRepository(User::class)
         ->find($_SESSION['idUser']);

        $carGroup = new CarGroup();
        $carGroup->setIduser($user)
                ->setName($data['name'])
                ->setMenuposition(1)
                ->setCreationdate(new \DateTime());

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($carGroup);
        $entityManager->flush();

        return $this->json(['message' => 'New car group created'], 200);
    }

    /**
     * @Route("/{idCarGroup}", methods={"DELETE"}, name="delete")
     */
    public function delete(int $idCarGroup)
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'You have to login'], 400);
        // find CarGroup by id, if not belong to user, return massage
        $carGroup = $this->getDoctrine()->getRepository(CarGroup::class)
        ->find($idCarGroup);
        if($carGroup->getIduser()->getId() != $_SESSION['idUser']) return $this->json(['message' => 'No access to car group'], 400);

        $entityManager = $this->getDoctrine()->getManager();
        // move all cars from group to default group
        $cars = $this->getDoctrine()->getRepository(Car::class)
        ->findByIdcargroup($idCarGroup);

        if($cars) {
            // get user default car group
            $defaultCarGroup = $this->getDoctrine()->getRepository(CarGroup::class)
            ->findByIduser($_SESSION['idUser']);

            foreach($cars as $car) {
                $car->setIdcargroup();
                $entityManager->flush($defaultCarGroup[0]);
            }
        }
        
        $entityManager->remove($carGroup);
        $entityManager->flush();

        return $this->json(['message' => 'Car group deleted']);
    }
}
