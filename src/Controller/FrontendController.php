<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class FrontendController extends AbstractController
{

    #[Route('/{vue}', name: 'frontend', requirements: ['vue' => '^(?!(api|rest)).+'], defaults: ['vue' => null])]
    public function index()
    {
        return $this->render('base.html.twig');
    }
}
