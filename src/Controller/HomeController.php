<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(EventRepository $eventRepo)
    {
        $lastEvents = $eventRepo->findLastsAddEvents(3);

        return $this->render('home/index.html.twig', [
            'events' => $lastEvents
        ]);
    }
}
