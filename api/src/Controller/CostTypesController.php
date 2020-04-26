<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\CostTypes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/cost_types", methods={"GET"}, name="cost_types_")
 */
class CostTypesController extends AbstractController
{
    /**
     * @Route("/", name="all")
     */
    public function index()
    {
        $costTypes = $this->getDoctrine()->getRepository(CostTypes::class)
        ->findAll();

        $response = [];
        foreach($costTypes as $type) {
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
        $costType = $this->getDoctrine()->getRepository(CostTypes::class)
        ->find($id);

        if(!$costType) return $this->json(['message' => 'No cost type with this ID'], 400);

        $response = [
            'id' => $costType->getId(),
            'name' => $costType->getName()
        ];

        return $this->json($response, 200);
    }
}
