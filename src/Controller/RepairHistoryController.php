<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\RepairHistory;
use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
/**
 * @Route("/repair_history", methods={"GET"}, name="repair_history_")
 */
class RepairHistoryController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="all")
     */
    public function index()
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'No access'], 404);
        
        $carList = $this->getDoctrine()->getRepository(Car::class)
        ->findByIduser($_SESSION['idUser']);
        if(!$carList) return $this->json(['message' => 'No cars'], 200);

        $response = [];

        foreach($carList as $car) {
            $repairList = $this->getDoctrine()->getRepository(RepairHistory::class)
            ->findByIdcar();

            if($repairList) {
                foreach($repairList as $repair) {
                    array_push($response, [
                        'id' => $repair->getId(),
                        'idCar' => $repair->getIdcar(),
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
     * @Route("/", methods={"GET"}, name="all")
     */
}
