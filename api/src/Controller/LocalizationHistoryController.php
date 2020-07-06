<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\LocalizationHistory;
use App\Entity\Car;
use App\Entity\User;
use App\Entity\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
/**
 * @Route("/localization_history", name="localization_history_")
 */
class LocalizationHistoryController extends AbstractController
{
    /**
     * @Route("/", methods={"GET", "POST"}, name="showAllByUser")
     */
    public function index(Request $request)
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'No access'], 404);
        
        $data = json_decode($request->getContent(), true);

        if(isset($data['idCar'])) $localizationHistoryList = $this->getDoctrine()->getRepository(LocalizationHistory::class)->findByIdcar($data['idCar']);
        else $localizationHistoryList = $this->getDoctrine()->getRepository(LocalizationHistory::class)->findByIduser($_SESSION['idUser']);
        
        if(!$localizationHistoryList) return $this->json(['message' => 'No localization history records'], 200);

        $response = [];
        foreach($localizationHistoryList as $record) {
            array_push($response, [
                'id' => $record->getId(),
                'idCar' => $record->getIdCar()->getId(),
                'startLat' => $record->getIdstartaddress()->getLat(),
                'startLng' => $record->getIdstartaddress()->getLng(),
                'endLat' => $record->getIdendaddress()->getLat(),
                'endLng' => $record->getIdendaddress()->getLng(),
                'distance' => $record->getDistance(),
                'description' => $record->getDescription(),
                'date' => $record->getDate()->format('Y-m-d')
            ]);
        }

        return $this->json($response, 200);
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="showById")
     */
    public function show($id)
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'No access'], 404);

        $localizationHistory = $this->getDoctrine()->getRepository(LocalizationHistory::class)->find($id);
        
        if(!$localizationHistory) return $this->json(['message' => 'No localization history records'], 200);
        if($localizationHistory->getIduser()->getId() != $_SESSION['idUser']) return $this->json(['message' => 'No access to localization history'], 400);

        $response = [
            'id' => $localizationHistory->getId(),
            'idCar' => $localizationHistory->getIdCar()->getId(),
            'startLat' => $localizationHistory->getIdstartaddress()->getLat(),
            'startLng' => $localizationHistory->getIdstartaddress()->getLng(),
            'endLat' => $localizationHistory->getIdendaddress()->getLat(),
            'endLng' => $localizationHistory->getIdendaddress()->getLng(),
            'distance' => $localizationHistory->getDistance(),
            'description' => $localizationHistory->getDescription(),
            'date' => $localizationHistory->getDate()->format('Y-m-d')
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

        $startAddress = new Address();
        $startAddress->setLat($data['startLat'])
                    ->setLng($data['startLng']);
        $entityManager->persist($startAddress);
        
        $endAddress = new Address();
        $endAddress->setLat($data['endLat'])
                    ->setLng($data['endLng']);
        $entityManager->persist($endAddress);

        $localizationHistory = new LocalizationHistory();
        $localizationHistory->setIdcar($car)
                            ->setIduser($user)
                            ->setIdstartaddress($startAddress)
                            ->setIdendaddress($endAddress)
                            ->setDate(new \DateTime($data['date']))
                            ->setDistance($data['distance'])
                            ->setDescription($data['description']);

        $entityManager->persist($localizationHistory);
        $entityManager->flush();

        return $this->json(['message' => 'Localization history added',
                            'id' => $localizationHistory->getId()]);
    }

    /**
     * @Route("/{id}", methods={"DELETE"}, name="delete")
     */
    public function delete(int $id)
    {
        session_start();
        $entityManager = $this->getDoctrine()->getManager();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'No access'], 404);

        $localizationHistory = $this->getDoctrine()->getRepository(LocalizationHistory::class)
        ->find($id);
        if(!$localizationHistory || $localizationHistory->getIduser()->getId() != $_SESSION['idUser']) return $this->json(['message' => 'No access'], 404);
        
        $entityManager->remove($localizationHistory);
        $entityManager->flush();
        return $this->json(['message' => 'Repair history removed']);

    }

}
