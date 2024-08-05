<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Form\UserEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ApiController extends AbstractFOSRestController
{


    #[Route("/users/{id}", name: "api_users_get", requirements: ["id" => "\d+"], methods: ["GET"]),]
    public function findUser(
        #[MapEntity(mapping: ["id" => "id"])] User $user
    )
    {
        return $this->view($user);
    }

    #[Route("/users/{id}", name: "api_user_edit_new", requirements: ["id" => "\d+"], methods: ["PUT", "PATCH"])]
    public function edit(
        #[MapEntity(mapping: ["id" => "id"])] User $user,
        Request $request, EntityManagerInterface $em

    )
    {
        $form = $this->createForm(UserEditFormType::class, $user);
        $form->handleRequest($request);
        $data = json_decode($request->getContent(), true);
        $form->submit($data, $request->getMethod() !== 'PATCH');
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();

            if ($request->getMethod() === 'PATCH') {
                return $this->handleView($this->view(null, Response::HTTP_NO_CONTENT));
            }

            return $this->handleView($this->view($data, Response::HTTP_CREATED));
        }

        return $this->handleView($this->view($form->getErrors(), Response::HTTP_BAD_REQUEST));
    }

}
