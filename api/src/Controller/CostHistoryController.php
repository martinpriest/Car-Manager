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
