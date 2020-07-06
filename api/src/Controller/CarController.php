<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Car;
use App\Entity\User;
use App\Entity\CarGroup;
use App\Entity\File;

/**
 * @Route("/car", name="car_")
 */
class CarController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="show")
     */
    public function index()
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'You have to login'], 400);
        // TODO: zamienic te ify na tablice kryterii i tylko raz wyszukiwac
        if(!isset($data['onlyPublic']) && !isset($_GET['idCarGroup'])) $cars = $this->getDoctrine()->getRepository(Car::class)->findByIduser($_SESSION['idUser']);
        if(isset($_GET['onlyPublic']) && $_GET['onlyPublic'] == 1) $cars = $this->getDoctrine()->getRepository(Car::class)->findBy(['ispublic' => true]);
        else if(isset($_GET['idCarGroup'])) $cars = $this->getDoctrine()->getRepository(Car::class)->findBy(['idcargroup' => intval($_GET['idCarGroup'])]);

        if(!$cars) return $this->json(['message' => 'No cars added'], 200);

        $response = [];
        foreach($cars as $car) {
            array_push($response, [
                'id' => $car->getId(),
                'idCarGroup' => $car->getIdcargroup()->getId(),
                'carGroupName' => $car->getIdcargroup()->getName(),
                'name' => $car->getName(),
                'isPublic' => $car->getIspublic(),
                'mark' => $car->getMark(),
                'model' => $car->getModel(),
                'year' => $car->getYear(),
                'hexColor' => $car->getHexcolor(),
                'engineMileage' => $car->getEnginemileage(),
                'idAvatarFile' => $car->getIdavatarfile()->getId(),
                'creationDate' => $car->getCreationdate(),
                'purchaseDate' => $car->getPurchasedate()
            ]);
        }

        return $this->json($response, 200);
    }

    /**
     * @Route("/{idCar}", methods={"GET"}, name="showById")
     */
    public function show(int $idCar)
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'You have to login'], 400);

        $car = $this->getDoctrine()->getRepository(Car::class)
        ->find($idCar);

        if(!$car) return $this->json(['message' => 'No cars with id'], 404);
        if($car->getIduser()->getId() != $_SESSION['idUser']) return $this->json(['message' => 'Its not your car'], 400);

        $response = [
            'id' => $car->getId(),
            'idCarGroup' => $car->getIdcargroup()->getId(),
            'carGroupName' => $car->getIdcargroup()->getName(),
            'mark' => $car->getMark(),
            'name' => $car->getName(),
            'isPublic' => $car->getIspublic(),
            'model' => $car->getModel(),
            'year' => $car->getYear(),
            'hexColor' => $car->getHexcolor(),
            'engineMileage' => $car->getEnginemileage(),
            'creationDate' => $car->getCreationdate(),
            'purchaseDate' => $car->getPurchasedate()
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

        $user = $this->getDoctrine()->getRepository(User::class)
         ->findById($_SESSION['idUser']);

        
        $data = json_decode($request->getContent(), true);

        $carGroup = $this->getDoctrine()->getRepository(CarGroup::class)
         ->find($data['idCarGroup']);

        $avatarFile = $this->getDoctrine()->getRepository(File::class)
         ->find(2);

        $car = new Car();
        $car->setIduser($user[0])
            ->setIdcargroup($carGroup)
            ->setIspublic(0)
            ->setName($data['name'])
            ->setMark($data['mark'])
            ->setModel($data['model'])
            ->setYear($data['year'])
            ->setHexcolor($data['hexColor'])
            ->setEnginemileage($data['engineMileage'])
            ->setIdavatarfile($avatarFile)
            ->setCreationdate(new \DateTime());

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($car);
        $entityManager->flush();

        return $this->json(['message' => 'New car created', 'id' => $car->getId()], 200);
    }

    /**
     * @Route("/{idCar}", methods={"PUT"}, name="update")
     */
    public function update(Request $request, int $idCar)
    {
        session_start();
        if(!isset($_SESSION['idUser'])) $this->json(['message' => 'No access'], 400);

        $car = $this->getDoctrine()->getRepository(Car::class)->find($idCar);
        if($_SESSION['idUser'] != $car->getIduser()->getId()) return $this->json(['message' => 'No access to car'], 400);
        if(!$car) return $this->json(['message' => 'Car not exist'], 400);

        $entityManager = $this->getDoctrine()->getManager();
        $data = json_decode($request->getContent(), true);

        // update car group
        if(isset($data['idCarGroup'])) {
            $carGroup = $this->getDoctrine()->getRepository(CarGroup::class)->find($data['idCarGroup']);
            if(!$carGroup) return $this->json(['message' => 'No car group'], 400);
            if($carGroup->getIduser()->getId() != $_SESSION['idUser']) return $this->json(['message' => 'No access to car group'], 400);
            
            $car->setIdcargroup($carGroup);
        }
        
        if(isset($data['isPublic'])) $car->setIspublic($data['isPublic']);
        if(isset($data['name'])) $car->setName($data['name']);
        if(isset($data['mark'])) $car->setMark($data['mark']);
        if(isset($data['model'])) $car->setModel($data['model']);
        if(isset($data['year'])) $car->setYear($data['year']);
        if(isset($data['hexColor'])) $car->setHexcolor($data['hexColor']);
        if(isset($data['engineMileage'])) $car->setEnginemileage($data['engineMileage']);
        
        $entityManager->flush();

        return $this->json(['message' => 'Car updated']);
    }

    /**
     * @Route("/{idCar}", methods={"DELETE"}, name="delete")
     */
    public function delete(int $idCar)
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'You have to login'], 400);
        $entityManager = $this->getDoctrine()->getManager();

        $carToDelete =$this->getDoctrine()->getRepository(Car::class)->find($idCar);

        if(!$carToDelete) return $this->json(['message' => 'No car with this ID'], 404);

        if($carToDelete->getIduser()->getId() != $_SESSION['idUser']) return $this->json(['message' => 'Its not your car'], 400);

        $entityManager->remove($carToDelete);
        $entityManager->flush();

        return $this->json(['message' => 'Car deleted'], 200);
    }
}
