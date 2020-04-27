<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAgendaController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_index")
     */
    public function index(EventRepository $eventRepo)
    {
        return $this->render('admin/index.html.twig', [
            'events' => $eventRepo->findLastsAddEvents()
        ]);
    }
}
