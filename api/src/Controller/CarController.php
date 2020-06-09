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
     * @Route("/{idCar}", methods={"GET"}, name="car_showById")
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
            'mark' => $car->getMark(),
            'name' => $car->getName(),
            'isPublic' => $car->getIspublic(),
            'model' => $car->getModel(),
            'year' => $car->getYear(),
            'hexColor' => $car->getHexcolor(),
            'engineMileage' => $car->getEnginemileage(),
            'imgPath' => $car->getImgpath(),
            'creationDate' => $car->getCreationdate(),
            'purchaseDate' => $car->getPurchasedate()
        ];

        return $this->json($response, 200);
    }

    /**
     * @Route("/create", methods={"POST"}, name="car_new")
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

        return $this->json(['message' => 'New car created'], 200);
    }

    /**
     * @Route("/{idCar}", methods={"PUT"}, name="car_update")
     */
    public function update(Request $request, int $idCar)
    {
        session_start();
        $data = json_decode($request->getContent(), true);
        if(!isset($_SESSION['idUser'])) $this->json(['message' => 'No access'], 400);
        $entityManager = $this->getDoctrine()->getManager();
        $car = $this->getDoctrine()->getRepository(Car::class)->find($id);
        if($_SESSION['idUser'] != $car->getIduser()->getId()) return $this->json(['message' => 'No access to car'], 400);
        if(!$user) return $this->json(['message' => 'User not exist'], 400);
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
