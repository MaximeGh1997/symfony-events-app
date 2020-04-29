<?php

namespace App\Controller;

use DateTime;
use App\Entity\Types;
use App\Repository\EventRepository;
use App\Repository\TypesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AgendaController extends AbstractController
{
    /**
     * // Permet d'afficher les prochains événements et de les trier par type
     * @Route("/agenda", name="agenda")
     */
    public function index(Request $request, EventRepository $eventRepo, TypesRepository $typesRepo)
    {
        $events = $eventRepo->findEventsByDate();
        $now = new \DateTime('Europe/Brussels');

        $typeId = $request->request->get('type'); // récupération de l'id correspondant au type
        if($typeId != null){
            $events = $eventRepo->findEventsByDateAndType($typeId);
        }

        return $this->render('agenda/index.html.twig', [
            'events' => $events,
            'now' => $now,
            'types' => $typesRepo->findAll()
        ]);
    }
}
