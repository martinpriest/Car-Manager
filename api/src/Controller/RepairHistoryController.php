<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\RepairHistory;
use App\Entity\Car;
use App\Entity\CostHistory;
use App\Entity\CostTypes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
/**
 * @Route("/repair_history", methods={"GET"}, name="repair_history_")
 */
class RepairHistoryController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="all")
     */
    public function index(Request $request)
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'No access'], 404);
        
        $carList = $this->getDoctrine()->getRepository(Car::class)->findByIduser($_SESSION['idUser']);
        $data = json_decode($request->getContent(), true);
        if(!isset($data['idCar'])) $carList = $this->getDoctrine()->getRepository(Car::class)->findByIduser($_SESSION['idUser']);
        else $carList = $this->getDoctrine()->getRepository(Car::class)->find($data['idCar']);

        if(!$carList) return $this->json(['message' => 'No cars'], 200);

        $response = [];

        foreach($carList as $car) {
            $repairList = $this->getDoctrine()->getRepository(RepairHistory::class)
            ->findByIdcar($car->getId());

            if($repairList) {
                foreach($repairList as $repair) {
                    array_push($response, [
                        'id' => $repair->getId(),
                        'idCar' => $repair->getIdcar()->getId(),
                        'description' => $repair->getDescription(),
                        'idFacture' => $repair->getIdfacture()->getId(),
                        'date' => $repair->getDate()
                    ]);
                }
            }
        }

        return $this->json($response, 200);
    }

    /**
     * @Route("/{idRepairHistory}", methods={"GET"}, name="getByID")
     */
    public function show(int $idRepairHistory)
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'No access'], 404);
        
        $repairHistory = $this->getDoctrine()->getRepository(RepairHistory::class)
        ->find($idRepairHistory);
        if(!$repairHistory) return $this->json(['message' => 'No repair history']);

        $response = [
            'id' => $repairHistory->getId(),
            'idCar' => $repairHistory->getIdcar()->getId(),
            'description' => $repairHistory->getDescription(),
            'idFacture' => $repairHistory->getIdfacture()->getId(),
            'date' => $repairHistory->getDate()
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
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'No access'], 404);
        $data = json_decode($request->getContent(), true);

        $car = $this->getDoctrine()->getRepository(Car::class)->find($data['idCar']);
        if($car->getIduser()->getId() != $_SESSION['idUser']) return $this->json(['message' => 'No access to cost history with this id'], 400);

        $costType = $this->getDoctrine()->getRepository(CostTypes::class)->find(1);

        $costHistory = new CostHistory();
        $costHistory->setIduser($_SESSION['idUser'])
                    ->setIdcosttype($costType)
                    ->setIdcar($data['idCar'])
                    ->setFactureimagepath("img/default.jpg")
                    ->setAmount($data['amount'])
                    ->setCurrency($data['currency'])
                    ->setExchangerate($data['exchangeRate'])
                    ->setDescription($data['description'])
                    ->setDate(new \DateTime($data['date']));

                    
        $entityManager->persist($costHistory);

        $repairHistory = new RepairHistory();
        $repairHistory->setIduser($_SESSION['idUser'])
                    ->setIdcar($car)
                    ->setDescription($data['description'])
                    ->setIdfacture($costHistory)
                    ->setDate(new \DateTime($data['date']));
        
        $entityManager->persist($repairHistory);
        $entityManager->flush();
        return $this->json(['message' => 'Repair history added']);

    }

    /**
     * @Route("/{idRepairHistory}", methods={"DELETE"}, name="delete")
     */
    public function delete(int $idRepairHistory)
    {
        session_start();
        $entityManager = $this->getDoctrine()->getManager();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'No access'], 404);

        $repairHistory = $this->getDoctrine()->getRepository(RepairHistory::class)
        ->find($idRepairHistory);
        if(!$repairHistory || $repairHistory->getIduser() != $_SESSION['idUser']) return $this->json(['message' => 'No access'], 404);
        
        $entityManager->remove($repairHistory);
        $entityManager->flush();
        return $this->json(['message' => 'Repair history removed']);

    }
}
