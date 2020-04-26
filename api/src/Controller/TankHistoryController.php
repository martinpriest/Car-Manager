<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TankHistoryController extends AbstractController
{
    /**
     * @Route("/tank/history", name="tank_history")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TankHistoryController.php',
        ]);
    }
}
