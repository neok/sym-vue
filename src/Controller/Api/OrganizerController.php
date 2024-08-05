<?php

namespace App\Controller\Api;

use App\Entity\Organizer;
use App\Repository\EventRepository;
use App\Repository\OrganizerRepository;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\Routing\Attribute\Route;
use FOS\RestBundle\View\View;

class OrganizerController extends AbstractFOSRestController
{


    #[Route('/organizers', name: 'api_organizers_get', methods: ['GET'])]
    public function getList(OrganizerRepository $organizerRepository)
    {
        // OFC, this is a very simple example, but you can do more complex stuff here
        // like pagination, filtering, etc.
        // for sake of simplicity, we just return all organizers
        $context = new Context();
        $context->addGroup('event_list');
        $organizers = $organizerRepository->findAll();
        $view = View::create()->setContext($context);
        return $view->setData($organizers);
    }

    #[Route('/organizers/{id}/events', name: 'api_organizers_events_get', methods: ['GET'])]
    public function getEvents(EventRepository $eventRepository,
         #[MapEntity(mapping: ["id" => "id"])] Organizer $organizer
    )
    {
        $context = new Context();
        $context->addGroup('orginizer_events');
        $events = $eventRepository->findBy(['organizer' => $organizer]);
        $view = View::create()->setContext($context);
        return $view->setData($events);
    }

}
