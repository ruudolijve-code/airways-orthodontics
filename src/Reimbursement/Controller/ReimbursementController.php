<?php

declare(strict_types=1);

namespace App\Reimbursement\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ReimbursementController extends AbstractController
{
    #[Route(
        '/vergoedingen',
        name: 'reimbursement_index',
        methods: ['GET']
    )]
    public function index(): Response
    {
        return $this->render('reimbursement/index.html.twig');
    }

    #[Route(
        '/vergoedingen/gratis-informatief-consult',
        name: 'reimbursement_consult',
        methods: ['GET']
    )]
    #[Route(
        '/gratis-informatief-consult',
        name: 'consult_index',
        methods: ['GET']
    )]
    public function show(): Response
    {
        return $this->render('reimbursement/consult.html.twig');
    }
}