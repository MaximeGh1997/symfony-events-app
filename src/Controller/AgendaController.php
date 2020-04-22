<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AgendaController extends AbstractController
{
    /**
     * @Route("/agenda", name="agenda")
     */
    public function index(EventRepository $eventRepo)
    {
        return $this->render('agenda/index.html.twig', [
            'events' => $eventRepo->findNextsEventsByType('Festival')
        ]);
    }
}
