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
                'description' => 'Orthodontische expertise binnen de multidisciplinaire behandeling van kaakontwikkeling, gebitsstand en ademhalingsgerelateerde problematiek.',
                'professionals' => [
                    [
                        'name' => 'drs. Bart Alink, MSc Orthodontics',
                        'function' => 'Tandarts voor Orthodontie',
                        'role' => 'Diagnostiek en orthodontische behandeling, met bijzondere expertise in kaakverbreding en de groei van de bovenkaak bij kinderen en volwassenen.',
                        'photo' => 'images/collaboration/professionals/bart-alink.jpg',
                        'BIG' => '89019669502',
                    ],
                    [
                        'name' => 'Dr. med. dent.Alexander Alink',
                        'function' => 'Tandarts – gespecialiseerd in restauratieve tandheelkunde en multidisciplinaire airway-zorg',
                        'role' => 'Orthodontische behandeling gericht op kaakontwikkeling, gebitsstand en, waar geïndiceerd, verbreding van de bovenkaak.',
                        'photo' => 'images/collaboration/professionals/alexander-alink.png',
                        'BIG' => '19933885302',
                    ],
                    [
                        'name' => 'drs. Alexandra Redmer, MSc Orthodontics',
                        'function' => 'Tandarts voor Orthodontie',
                        'role' => 'Orthodontische behandeling gericht op kaakontwikkeling, gebitsstand en, waar geïndiceerd, verbreding van de bovenkaak.',
                        'photo' => 'images/collaboration/professionals/alexandra-redmer.jpg',
                        'BIG' => '79916538102',
                    ],
                ],
            ],
            [
                'name' => 'Kaakmeesterz',
                'logo' => 'images/collaboration/kaakmeesterz.svg',
                'description' => 'Specialistische kaakchirurgische expertise wanneer anatomie of kaakpositie aanleiding geeft voor aanvullende diagnostiek of chirurgische behandeling.',
                'professionals' => [
                    [
                        'name' => 'Dr. Frank Leusink',
                        'function' => 'Kaakchirurg',
                        'role' => 'Beoordeling van kaakpositie en anatomie en, wanneer nodig, uitvoering of advisering van kaakchirurgische behandelopties.',
                        'photo' => 'images/collaboration/professionals/frank-leusink.jpg',
                    ],
                ],
            ],
            [
                'name' => 'Daniels Tandheelkunde',
                'logo' => 'images/collaboration/daniels.svg',
                'description' => 'Tandheelkundige expertise met bijzondere aandacht voor de relatie tussen mondfunctie, gebit, tongpositie en luchtweg.',
                'professionals' => [
                    [
                        'name' => 'Nurcan Yilmaz',
                        'function' => 'Reconstructief & restauratief tandarts',
                        'role' => 'Herkenning en beoordeling van airway-gerelateerde mond- en gebitsproblematiek, verwijzing naar de juiste specialist en uitvoering van kleinere ingrepen zoals een tongriemcorrectie wanneer dit geïndiceerd is.',
                        'photo' => 'images/collaboration/professionals/nurcan-yilmaz.jpg',
                    ],
                ],
            ],
            [
                'name' => 'Ademwinst',
                'logo' => 'images/collaboration/ademwinst.svg',
                'description' => 'Functionele begeleiding gericht op neusademhaling, ademhalingspatronen en het ondersteunen van een stabiel behandelresultaat.',
                'professionals' => [
                    [
                        'name' => 'Steven Zwerink',
                        'function' => 'Ademfysioloog',
                        'role' => 'Begeleiding vóór, tijdens en vooral na de orthodontische of kaakchirurgische behandeling naar een efficiëntere neusademhaling en een functioneel ademhalingspatroon.',
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