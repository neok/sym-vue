<?php

namespace App\Controller\Api;

use App\Entity\Event;
use App\Repository\OrganizerRepository;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\Routing\Attribute\Route;
use FOS\RestBundle\View\View;

class EventsController extends AbstractFOSRestController
{
    #[Route('/events/{id}', name: 'api_events_get', methods: ['GET'])]
    public function getEvent(
        #[MapEntity(mapping: ["id" => "id"])] Event $event
    )
    {
        $context = new Context();
        $context->addGroup('event_edit');
        $view = View::create()->setContext($context);
        return $view->setData($event);
    }

    #[Route('/events/{id}', name: 'api_events_delete', methods: ['DELETE'])]
    public function deleteEvent(
        EntityManagerInterface $em,
        #[MapEntity(mapping: ["id" => "id"])] Event $event
    )
    {
        $em->remove($event);
        $em->flush();
        return $this->handleView($this->view(null, 204));
    }

    #[Route('/events/{id}/tickets', name: 'api_events_tickets_get', methods: ['GET'])]
    public function getEventTickets(
        #[MapEntity(mapping: ["id" => "id"])] Event $event
    )
    {
        $context = new Context();
        $context->addGroup('event_tickets');
        $view = View::create()->setContext($context);
        return $view->setData($event->getTickets());
    }
}
