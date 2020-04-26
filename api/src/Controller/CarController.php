<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/car")
 */
class CarController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="car_show")
     */
    public function index()
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'You have to login'], 400);

        $cars = $this->getDoctrine()->getRepository(Car::class)
        ->findByIduser($_SESSION['idUser']);

        if(!$cars) return $this->json(['message' => 'No cars added'], 200);

        $response = [];
        foreach($cars as $car) {
            array_push($response, [
                'id' => $car->getId(),
                'mark' => $car->getMark(),
                'model' => $car->getModel(),
                'color' => $car->getColor(),
                'engineMileage' => $car->getEnginemileage(),
                'imgPath' => $car->getImgpath(),
                'creationDate' => $car->getCreationdate(),
                'purchaseDate' => $car->getPurchasedate()
            ]);
        }

        return $this->json($response, 200);
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="car_showById")
     */
    public function show(int $id)
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'You have to login'], 400);

        $car = $this->getDoctrine()->getRepository(Car::class)
        ->findById($id);

        if(!$car) return $this->json(['message' => 'No cars with id'], 404);
        if($car[0]->getIduser()->getId() != $_SESSION['idUser']) return $this->json(['message' => 'Its not your car'], 400);

        $response = [
            'id' => $car[0]->getId(),
            'mark' => $car[0]->getMark(),
            'model' => $car[0]->getModel(),
            'color' => $car[0]->getColor(),
            'engineMileage' => $car[0]->getEnginemileage(),
            'imgPath' => $car[0]->getImgpath(),
            'creationDate' => $car[0]->getCreationdate(),
            'purchaseDate' => $car[0]->getPurchasedate()
        ];

        return $this->json($response, 200);
    }

    /**
     * @Route("/{mark}/{model}/{color}/{engineMileage}", methods={"POST"}, name="car_new")
     */
    public function create($mark, $model, $color, $engineMileage)
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'You have to login'], 400);

        $user = $this->getDoctrine()->getRepository(User::class)
         ->findById($_SESSION['idUser']);

        $car = new Car();
        $car->setIduser($user[0])
            ->setMark($mark)
            ->setModel($model)
            ->setColor($color)
            ->setEnginemileage($engineMileage)
            ->setImgpath('img/car/car-default.png')
            ->setCreationdate(new \DateTime());

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($car);
        $entityManager->flush();

        return $this->json(['message' => 'New car created'], 200);
    }

    /**
     * @Route("/{id}", methods={"DELETE"}, name="car_delete")
     */
    public function delete(int $id)
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'You have to login'], 400);
        $entityManager = $this->getDoctrine()->getManager();

        $carToDelete =$this->getDoctrine()->getRepository(Car::class)->find($id);

        if(!$carToDelete) return $this->json(['message' => 'No car with this ID'], 404);

        if($carToDelete->getIduser()->getId() != $_SESSION['idUser']) return $this->json(['message' => 'Its not your car'], 400);

        $entityManager->remove($carToDelete);
        $entityManager->flush();

        return $this->json(['message' => 'Car deleted'], 200);
    }
}
