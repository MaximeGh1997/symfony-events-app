<?php

namespace App\Controller;

use DateTime;
use App\Entity\Types;
use App\Form\SelectTypesType;
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
        $now = new \DateTime();

        $types = new Types();
        $form = $this->createForm(SelectTypesType::class, $types);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $typeId = $types->getTitle(); // récupération du chiffre correspondant au titre du type
            
            if($typeId != null){
                $events = $eventRepo->findEventsByDateAndType($typeId);
            }
        }

        return $this->render('agenda/index.html.twig', [
            'events' => $events,
            'form' => $form->createView(),
            'now' => $now
        ]);
    }
}
