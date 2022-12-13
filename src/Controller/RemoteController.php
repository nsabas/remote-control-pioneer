<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RemoteController extends AbstractController
{
    #[Route('/', name: 'app_remote')]
    public function index(): Response
    {
        return $this->render(
            'remote/remote.html.twig'
        );
    }
}
