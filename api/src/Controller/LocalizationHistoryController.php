<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LocalizationHistoryController extends AbstractController
{
    /**
     * @Route("/localization/history", name="localization_history")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/LocalizationHistoryController.php',
        ]);
    }
}
