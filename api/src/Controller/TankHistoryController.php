<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\CostHistory;
use App\Entity\User;
use App\Entity\CostTypes;
use App\Entity\PetrolTypes;
use App\Entity\TankHistory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
/**
* @Route("/tank_history", name="tank_history_")
*/
class TankHistoryController extends AbstractController
{
    /**
     * @Route("/create", methods={"POST"}, name="create")
     */
    public function create(Request $request)
    {
        session_start();
        $entityManager = $this->getDoctrine()->getManager();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'No access']);
        $data = json_decode($request->getContent(), true);

        $car = $this->getDoctrine()->getRepository(Car::class)->find($data['idCar']);
        if($car->getIdUser()->getId() != $_SESSION['idUser']) return $this->json(['message' => 'No access']);
        $costType = $this->getDoctrine()->getRepository(CostTypes::class)->find(2);
        $petrolType = $this->getDoctrine()->getRepository(PetrolTypes::class)->find($data['idPetrolType']);

        $user = $this->getDoctrine()->getRepository(User::class)->find($_SESSION['idUser']);
        $facture = new CostHistory();
        $facture->setIdcar($car)
                ->setIduser($user)
                ->setIdcosttype($costType)
                ->setExchangerate($data['exchangeRate'])
                ->setCurrency($data['currency'])
                ->setAmount($data['priceAmount'])
                ->setDescription($data['description'])
                ->setFactureimagepath('img/default-facture.jpg')
                ->setDate(new \DateTime($data['date']));

        $entityManager->persist($facture);
        
        $tankHistory = new TankHistory();
        $tankHistory->setIdcar($car)
                    ->setIduser($user)
                    ->setIdpetroltype($petrolType)
                    ->setPetrolstation($data['petrolStation'])
                    ->setDate(new \DateTime($data['date']))
                    ->setAmount($data['fuelAmount'])
                    ->setIdfacture($facture);
        
        $entityManager->persist($tankHistory);
        $entityManager->flush();

        return $this->json(['message' => 'Tank added',
        'id' => $tankHistory->getId()]);
    }

    /**
     * @Route("/", methods={"GET", "POST"}, name="readAll")
     */
    public function index(Request $request)
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'You have to login'], 400);

        $data = json_decode($request->getContent(), true);

        if(isset($data['idCar'])) $tankHistory = $this->getDoctrine()->getRepository(TankHistory::class)->findByIdcar($data['idCar']);
        else $tankHistory = $this->getDoctrine()->getRepository(TankHistory::class)->findByIduser($_SESSION['idUser']);

        if(!$tankHistory) return $this->json(['message' => 'No tank added'], 200);


        $response = [];
        foreach($tankHistory as $record) {
            array_push($response, [
                'id' => $record->getId(),
                'idUser' => $record->getIdUser()->getId(),
                'idCar' => $record->getIdCar()->getId(),
                'idPetrolType' => $record->getIdpetroltype()->getId(),
                'petrolTypeName' => $record->getIdpetroltype()->getName(),
                'petrolStation' => $record->getPetrolstation(),
                'date' => $record->getDate()->format('Y-m-d'),
                'idFacture' => $record->getIdfacture()->getId(),
                'amount' => $record->getAmount()
            ]);
        }

        return $this->json($response, 200);
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="readById")
     */
    public function readById(int $id)
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'You have to login'], 400);

        $tankHistory = $this->getDoctrine()->getRepository(TankHistory::class)
        ->find($id);

        if(!$tankHistory) return $this->json(['message' => 'No tank added'], 200);
        if($tankHistory->getIduser() != $_SESSION['idUser']) return $this->json(['message' => 'No access'], 404);

        $response = [
            'id' => $tankHistory->getId(),
            'idUser' => $tankHistory->getIdUser()->getId(),
            'idCar' => $tankHistory->getIdCar()->getId(),
            'idPetrolType' => $tankHistory->getIdpetroltype()->getId(),
            'petrolTypeName' => $tankHistory->getIdpetroltype()->getName(),
            'petrolStation' => $tankHistory->getPetrolstation(),
            'date' => $tankHistory->getDate()->format('Y-m-d'),
            'amount' => $tankHistory->getAmount()
        ];

        return $this->json($response, 200);
    }

    /**
     * @Route("/{id}", methods={"DELETE"}, name="delete")
     */
    public function delete(int $id)
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'You have to login'], 400);
        $entityManager = $this->getDoctrine()->getManager();

        $tankToDelete = $this->getDoctrine()->getRepository(TankHistory::class)->find($id);

        if(!$tankToDelete) return $this->json(['message' => 'No car with this ID'], 404);
        if($tankToDelete->getIduser()->getId() != $_SESSION['idUser']) return $this->json(['message' => 'Its not your car'], 400);

        $costToDelete = $this->getDoctrine()->getRepository(CostHistory::class)->find($tankToDelete->getIdfacture());

        $entityManager->remove($tankToDelete);
        $entityManager->remove($costToDelete);
        $entityManager->flush();

        return $this->json(['message' => 'Tank deleted'], 200);
    }
}
