<?php

declare(strict_types=1);

namespace App\Approach\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ApproachController extends AbstractController
{
    #[Route(
        '/onze-aanpak',
        name: 'approach_index',
        methods: ['GET'],
    )]
    public function index(): Response
    {
        return $this->render('approach/index.html.twig');
    }
}