<?php

declare(strict_types=1);

namespace App\Collaboration\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CollaborationController extends AbstractController
{
    #[Route('/samenwerking', name: 'collaboration_index', methods: ['GET'])]
    public function index(): Response
    {
        $partners = [
            [
                'name' => 'Ortho Euregio',
                'logo' => 'images/collaboration/ortho-euregio.svg',
                'description' => 'Orthodontische expertise binnen de multidisciplinaire beoordeling en behandeling van luchtweg-, groei- en kaakgerelateerde problematiek.',
                'professionals' => [
                    [
                        'name' => 'Bart Alink',
                        'function' => 'Tandarts & Orthodontics MSc',
                        'role' => 'Kaakverbreding en groei van de bovenkaak, 30 jaar ervaring in de behandeling van kinderen en volwassenen met een smalle bovenkaak en ademhalingsproblemen',
                        'photo' => 'images/collaboration/professionals/bart-alink.jpg',
                        
                    ],
                    [
                        'name' => 'Alexander Alink',
                        'function' => 'Tandarts & Orthodontics MSc',
                        'role' => 'Orthodontische behandeling door kaakverbeding waarmee ademhalingsproblemen en kaakgerelateerde klachten zich kunnen verbeteren',
                        'photo' => 'images/collaboration/professionals/alexander-alink.png',
                        'BIG' => '19933885302',
                    ],
                    [
                        'name' => 'Alexandra Redmer',
                        'function' => 'Orthodontics MSc',
                        'role' => 'Orthodontische behandeling door kaakverbeding waarmee ademhalingsproblemen en kaakgerelateerde klachten zich kunnen verbeteren',
                        'photo' => 'images/collaboration/professionals/alexandra-redmer.jpg',
                    ],
                ],
            ],
            [
                'name' => 'Kaakmeesterz',
                'logo' => 'images/collaboration/kaakmeesterz.svg',
                'description' => 'Specialistische expertise op het gebied van kaakchirurgie, kaakpositie en de relatie tussen anatomie, luchtweg en ademhaling.',
                'professionals' => [
                    [
                        'name' => 'Frank Leusink',
                        'function' => 'Kaakchirurg',
                        'role' => 'Beoordeling van kaakpositie en chirurgische behandelopties',
                        'photo' => 'images/collaboration/professionals/frank-leusink.jpg',
                    ],
                ],
            ],
            [
                'name' => 'Ademwinst',
                'logo' => 'images/collaboration/ademwinst.svg',
                'description' => 'Expertise op het gebied van functionele ademhaling, ademhalingspatronen en begeleiding naar een efficiëntere neusademhaling.',
                'professionals' => [
                    [
                        'name' => 'Steven Zwerink',
                        'function' => 'Ademfysioloog',
                        'role' => 'Na de behandeling van de kaak en tanden, begeleiding naar een efficiëntere neusademhaling en een verbeterd ademhalingspatroon',
                        'photo' => 'images/collaboration/professionals/steven-zwerink.jpg',
                    ],
                ],
            ],
        ];

        return $this->render('collaboration/index.html.twig', [
            'partners' => $partners,
        ]);
    }
}