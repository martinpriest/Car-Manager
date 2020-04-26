<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\PetrolTypes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/petrol_types", methods={"GET"}, name="petrol_types_")
 */
class PetrolTypesController extends AbstractController
{
    /**
     * @Route("/", name="show")
     */
    public function index()
    {
        $petrolTypes = $this->getDoctrine()->getRepository(PetrolTypes::class)
        ->findAll();

        $response = [];
        foreach($petrolTypes as $type) {
            array_push($response, [
                'id' => $type->getId(),
                'name' => $type->getName()
            ]);
        }

        return $this->json($response, 200);
    }

    /**
     * @Route("/{id}", name="byId")
     */
    public function show($id)
    {
        $petrolType = $this->getDoctrine()->getRepository(PetrolTypes::class)
        ->find($id);

        if(!$petrolType) return $this->json(['message' => 'No petrol type with this ID'], 400);

        $response = [
            'id' => $petrolType->getId(),
            'name' => $petrolType->getName()
        ];

        return $this->json($response, 200);
    }
}
