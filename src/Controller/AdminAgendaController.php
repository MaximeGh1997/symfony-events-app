<?php

namespace App\Controller;

use DateTime;
use DateTimeZone;
use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

    /**
     * @Route("/admin/new", name="admin_create")
     * 
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($event);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'événement {$event->getName()} à bien été ajouté"
            );

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/{id}/edit", name="admin_edit")
     * 
     * @return Response
     */
    public function edit(Event $event, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $event->setCreatedAt(new \DateTime('Europe/Brussels'));

            $manager->persist($event);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'événement {$event->getName()} à bien été modifié"
            );

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/edit.html.twig', [
            'form' => $form->createView(),
            'event' => $event
        ]);
    }

    /**
     * @Route("/admin/{id}/delete", name="admin_delete")
     * 
     * @return Response
     */
    public function delete(Event $event, EntityManagerInterface $manager)
    {
        $manager->remove($event);
        $manager->flush();
        $this->addFlash(
            "success",
            "L'événement {$event->getName()} a bien été supprimé"
        );
        return $this->redirectToRoute('admin_index');
    }
}
