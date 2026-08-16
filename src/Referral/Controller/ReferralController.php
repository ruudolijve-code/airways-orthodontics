<?php

declare(strict_types=1);

namespace App\Referral\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ReferralController extends AbstractController
{
    #[Route(
        '/patient-verwijzen',
        name: 'referral_index',
    )]
    public function index(): Response
    {
        return $this->render('referral/index.html.twig');
    }
}