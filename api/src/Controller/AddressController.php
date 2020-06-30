<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/address", name="address_")
 */
class AddressController extends AbstractController
{
    /**
     * @Route("/{idAddress}", methods={"GET"}, name="show")
     */
    public function show(int $idAddress)
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'No access'], 404);

        $address = $this->getDoctrine()->getRepository(Address::class)->find($idAddress);
        if(!$address) return $this->json(['message' => 'No address'], 404);
        
        $response = [
            'id' => $address->getId(),
            'lat' => $address->getLat(),
            'lng' => $address->getLng()
        ];

        return $this->json($response, 200);
    }

    /**
     * @Route("/", methods={"POST"}, name="create")
     */
    public function create(Request $request)
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'No access'], 404);

        $entityManager = $this->getDoctrine()->getManager();
        $data = json_decode($request->getContent(), true);

        $address = new Address();
        $address->setLat($data['lat'])
                ->setLng($data['lng']);

        $entityManager->persist($address);
        $entityManager->flush();
        return $this->json(['message' => 'Address added']);
    }

    /**
     * @Route("/{idAddress}", methods={"PUT"}, name="update")
     */
    public function update(Request $request, int $idAddress)
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'No access'], 404);

        $entityManager = $this->getDoctrine()->getManager();
        $data = json_decode($request->getContent(), true);

        $address = $this->getDoctrine()->getRepository(Address::class)->find($idAddress);
        if(isset($data['lng'])) $address->setLng($data['lng']);
        if(isset($data['lat'])) $address->setLat($data['lat']);

        $entityManager->flush();

        return $this->json(['message' => 'Address updated']);
    }

    /**
     * @Route("/{idAddress}", methods={"DELETE"}, name="delete")
     */
    public function delete(int $idAddress)
    {
        session_start();
        if(!isset($_SESSION['idUser'])) return $this->json(['message' => 'No access'], 404);

        $entityManager = $this->getDoctrine()->getManager();

        $address = $this->getDoctrine()->getRepository(Address::class)->find($idAddress);
        if(!$address) return $this->json(['message' => 'Address not exist'], 400);
        $entityManager->remove($address);
        $entityManager->flush();

        return $this->json(['message' => 'Address deleted'], 200);
    }
}
