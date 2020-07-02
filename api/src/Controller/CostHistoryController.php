<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
use App\Entity\Car;
use App\Entity\CostHistory;
use App\Entity\CostTypes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
/**
 * @Route("/cost_history", name="cost_history_")
 */
class CostHistoryController extends AbstractController
{
    /**
     * @Route("/", methods={"GET", "POST"}, name="allByUser")
     */
    public function index(Request $request)
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'No access'], 404);

        $response = [];
        $idCar = $request->query->get('idCar');

        $costList = $this->getDoctrine()->getRepository(CostHistory::class);
        if($idCar != null) {
            $costList = $this->getDoctrine()->getRepository(CostHistory::class)->findByIdcar($idCar);
            foreach($costList as $cost) {
                array_push($response, [
                    'id' => $cost->getId(),
                    'idCostType' => $cost->getIdcosttype()->getId(),
                    'costType' =>  $cost->getIdcosttype()->getName(),
                    'idCar' => $cost->getIdcar(),
                    'factureImagePath' => $cost->getFactureimagepath(),
                    'amount' => $cost->getAmount(),
                    'currency' => $cost->getCurrency(),
                    'exchangeRate' => $cost->getExchangerate(),
                    'description' => $cost->getDescription(),
                    'date' => $cost->getDate()
                ]);
            }
        } else {
            $carList = $this->getDoctrine()->getRepository(Car::class)->findByIduser($_SESSION['idUser']);
            if(!$carList) return $this->json(['message' => 'No cars'], 200);

            foreach($carList as $car) {
                $costList = $this->getDoctrine()->getRepository(CostHistory::class)->findByIdcar($car->getId());

                if($costList) {
                    foreach($costList as $cost) {
                        array_push($response, [
                            'id' => $cost->getId(),
                            'idCostType' => $cost->getIdcosttype()->getId(),
                            'costType' =>  $cost->getIdcosttype()->getName(),
                            'idCar' => $cost->getIdcar()->getId(),
                            'factureImagePath' => $cost->getFactureimagepath(),
                            'amount' => $cost->getAmount(),
                            'currency' => $cost->getCurrency(),
                            'exchangeRate' => $cost->getExchangerate(),
                            'description' => $cost->getDescription(),
                            'date' => $cost->getDate()
                        ]);
                    }
                }
            }
        }
        
        return $this->json($response, 200);
    }

    /**
     * @Route("/aggregate", methods={"GET"}, name="aggregateByIdCostType")
     */
    public function aggregate()
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'No access'], 404);

        $response = [];

        $costList = $this->getDoctrine()->getRepository(CostHistory::class)->findByIduser($_SESSION['idUser']);

        if($costList) {
            $temp = ["1" => 0,
                    "2" => 0,
                    "3" => 0,
                    "4" => 0,
                    "5" => 0,
                    "6" => 0,
                    "7" => 0];
            foreach($costList as $cost) {

                if(!array_key_exists($cost->getIdcosttype()->getId(), $temp)) {
                    $temp[$cost->getIdcosttype()->getId()] = 0;
                }
                $temp[$cost->getIdcosttype()->getId()] += $cost->getAmount() * $cost->getExchangerate();
            }
        }

        return $this->json($temp, 200);
    }

    /**
     * @Route("/aggregate2", methods={"GET"}, name="aggregateCostByCars")
     */
    public function aggregateCostByCars()
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'No access'], 404);

        $cars = $this->getDoctrine()->getRepository(Car::class)->findByIduser($_SESSION['idUser']);
        if(!$cars) return $this->json(['message' => 'No cars'], 404);

        $response = [];
        foreach($cars as $car) {
            $totalCost = 0;
            $totalTankCost = 0;
            $totalRepairCost = 0;
            
            // count total cost
            $costList = $this->getDoctrine()->getRepository(CostHistory::class)->findByIdcar($car->getId());
            
            foreach ($costList as $cost) {
                $totalCost += $cost->getAmount() * $cost->getExchangerate();
                // naprawy
                if($cost->getIdcosttype()->getId() == 1) $totalRepairCost += $cost->getAmount() * $cost->getExchangerate();
                if($cost->getIdcosttype()->getId() == 2) $totalTankCost += $cost->getAmount() * $cost->getExchangerate();
            }

            $actualCar = [
                'idCar' => $car->getId(),
                'carName' => $car->getName(),
                'carGroupName' =>  $car->getIdcargroup()->getName(),
                'totalCost' => round($totalCost,2),
                'totalTankCost' => round($totalTankCost,2),
                'totalRepairCost' => round($totalRepairCost,2)
            ];
            array_push($response, $actualCar);
        }

        return $this->json($response, 200);
    }
    /**
     * @Route("/{id}", methods={"GET"}, name="getOneById")
     */
    public function show($id)
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'No access'], 404);

        $response = [];

        $cost = $this->getDoctrine()->getRepository(CostHistory::class)->find($id);
        if(!$cost) return $this->json(['message' => 'No cost with this ID'], 200);
    
        $car = $this->getDoctrine()->getRepository(Car::class)->find($cost->getIdcar());
        if($car->getIduser()->getId() != $_SESSION['idUser']) return $this->json(['message' => 'No access to cost history with this id'], 400);

        $response = [
            'id' => $cost->getId(),
            'idCostType' => $cost->getIdcosttype()->getId(),
            'costType' =>  $cost->getIdcosttype()->getName(),
            'idCar' => $cost->getIdcar()->getId(),
            'factureImagePath' => $cost->getFactureimagepath(),
            'amount' => $cost->getAmount(),
            'currency' => $cost->getCurrency(),
            'exchangeRate' => $cost->getExchangerate(),
            'description' => $cost->getDescription(),
            'date' => $cost->getDate()
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

        $user = $this->getDoctrine()->getRepository(User::class)->find($_SESSION['idUser']);
        $costType = $this->getDoctrine()->getRepository(CostTypes::class)->find($data['idCostType']);

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
        $entityManager->flush();
        
        return $this->json(['message' => 'Cost history added']);
    }
}
