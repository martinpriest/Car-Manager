<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\CostHistory;
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
     * @Route("/create", methods={"POST"} name="create")
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

        $facture = new CostHistory();
        $facture->setIdcar($data['idCar'])
                ->setIduser($_SESSION['idUser'])
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
                    ->setIduser($_SESSION['idUser'])
                    ->setIdpetroltype($petrolType)
                    ->setPetrolstation($data['petrolStation'])
                    ->setDate(new \DateTime($data['date']))
                    ->setAmount($data['fuelAmount'])
                    ->setIdfacture($facture);
        
        $entityManager->persist($tankHistory);
        $entityManager->flush();

        return $this->json(['message' => 'Tank added']);
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
                'idUser' => $record->getIdUser(),
                'idCar' => $record->getIdCar()->getId(),
                'idPetrolType' => $record->getIdpetroltype()->getId(),
                'petrolStation' => $record->getPetrolstation(),
                'date' => $record->getDate(),
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
            'idUser' => $tankHistory->getIdUser(),
            'idCar' => $tankHistory->getIdCar()->getId(),
            'idPetrolType' => $tankHistory->getIdpetroltype()->getId(),
            'petrolTypeName' => $tankHistory->getIdpetroltype()->getName(),
            'petrolStation' => $tankHistory->getPetrolstation(),
            'date' => $tankHistory->getDate(),
            'amount' => $tankHistory->getAmount()
        ];

        return $this->json($response, 200);
    }
}
