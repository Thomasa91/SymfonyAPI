<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{   
    // This endpoint returns 200 if token is valid or 401 when token is invalid or there is none,
    // might be used by client to check if user is authenticated
    #[Route('api/auth', name: 'app')]
    public function index(): Response
    {
        return new Response();
    }
}
