<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\RepairHistory;
use App\Entity\Car;
use App\Entity\User;
use App\Entity\CostHistory;
use App\Entity\CostTypes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
/**
 * @Route("/repair_history", name="repair_history_")
 */
class RepairHistoryController extends AbstractController
{
    /**
     * @Route("/", methods={"GET", "POST"}, name="all")
     */
    public function index(Request $request)
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'No access'], 404);
        $data = json_decode($request->getContent(), true);
        
        if(!isset($data['idCar'])) $repairHistory = $this->getDoctrine()->getRepository(RepairHistory::class)->findByIduser($_SESSION['idUser']);
        else $repairHistory = $this->getDoctrine()->getRepository(RepairHistory::class)->findByIdcar($data['idCar']);

        if(!$repairHistory) return $this->json(['message' => 'No repair history'], 200);

        $response = [];

        foreach($repairHistory as $repair) {
            array_push($response, [
                'id' => $repair->getId(),
                'idCar' => $repair->getIdcar()->getId(),
                'description' => $repair->getDescription(),
                'idFacture' => $repair->getIdfacture()->getId(),
                'date' => $repair->getDate()->format('Y-m-d')
            ]);
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
            'date' => $repairHistory->getDate()->format('Y-m-d')
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

        $user = $this->getDoctrine()->getRepository(User::class)->find($_SESSION['idUser']);
        $costHistory = new CostHistory();
        $costHistory->setIduser($user)
                    ->setIdcosttype($costType)
                    ->setIdcar($car)
                    ->setFactureimagepath("img/default.jpg")
                    ->setAmount($data['amount'])
                    ->setCurrency($data['currency'])
                    ->setExchangerate($data['exchangeRate'])
                    ->setDescription($data['description'])
                    ->setDate(new \DateTime($data['date']));

                    
        $entityManager->persist($costHistory);

        $repairHistory = new RepairHistory();
        $repairHistory->setIduser($user)
                    ->setIdcar($car)
                    ->setDescription($data['description'])
                    ->setIdfacture($costHistory)
                    ->setDate(new \DateTime($data['date']));
        
        $entityManager->persist($repairHistory);
        $entityManager->flush();
        return $this->json(['message' => 'Repair history added',
        'id' => $repairHistory->getId()]);

    }

    /**
     * @Route("/{idRepairHistory}", methods={"DELETE"}, name="delete")
     */
    public function delete(int $idRepairHistory)
    {
        session_start();
        $entityManager = $this->getDoctrine()->getManager();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'No access'], 404);

        $repairHistory = $this->getDoctrine()->getRepository(RepairHistory::class)->find($idRepairHistory);
        if(!$repairHistory || $repairHistory->getIduser()->getId() != $_SESSION['idUser']) return $this->json(['message' => 'No access'], 404);

        $costToDelete = $this->getDoctrine()->getRepository(CostHistory::class)->find($repairHistory->getIdfacture());
        
        $entityManager->remove($repairHistory);
        $entityManager->remove($costToDelete);
        $entityManager->flush();
        return $this->json(['message' => 'Repair history removed']);

    }
}
