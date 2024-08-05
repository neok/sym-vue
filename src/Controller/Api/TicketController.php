<?php

namespace App\Controller\Api;

use App\Entity\Ticket;
use App\Form\TicketCreateFormType;
use App\Form\TicketEditType;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use FOS\RestBundle\View\View;

class TicketController extends AbstractFOSRestController
{
    #[Route('/tickets/{id}', name: 'api_tickets_get', methods: ['GET'])]
    public function getTicket(
        #[MapEntity(mapping: ["id" => "id"])] Ticket $ticket
    )
    {
        $context = new Context();
        $context->addGroup('default');
        $view = View::create()->setContext($context);
        return $view->setData($ticket);
    }

    #[Route('/tickets/{id}', name: 'api_tickets_edit', methods: ['PATCH'])]
    public function editTicket(
        #[MapEntity(mapping: ["id" => "id"])] Ticket $ticket,
        Request                                      $request,
        EntityManagerInterface                       $em
    )
    {
        return $this->handleForm($em, $request, $ticket);
    }

    #[Route('/tickets', name: 'api_tickets_create', methods: ['POST'])]
    public function createTicket(Request $request, EntityManagerInterface $em)
    {
        return $this->handleForm($em, $request, new Ticket(), TicketCreateFormType::class);
    }

    #[Route('/tickets/{id}', name: 'api_tickets_delete', methods: ['DELETE'])]
    public function deleteTicket(
        EntityManagerInterface $em,
        #[MapEntity(mapping: ["id" => "id"])] Ticket $ticket
    )
    {
        $em->remove($ticket);
        $em->flush();
        return $this->handleView($this->view(null, 204));
    }


    private function handleForm(EntityManagerInterface $em, Request $request, Ticket $ticket, string $formType = TicketEditType::class): Response
    {
        $form = $this->createForm($formType, $ticket);
        $form->handleRequest($request);
        $data = json_decode($request->getContent(), true);
        if ($request->getMethod() === 'PATCH') {
            $form->submit($data, $request->getMethod() !== 'PATCH');
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($ticket);
            $em->flush();

            if ($request->getMethod() === 'PATCH') {
                return $this->handleView($this->view(null, Response::HTTP_NO_CONTENT));
            }

            return $this->handleView($this->view($data, Response::HTTP_CREATED));
        }

        return $this->handleView($this->view($form->getErrors(), Response::HTTP_BAD_REQUEST));
    }

}
