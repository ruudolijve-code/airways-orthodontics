<?php

declare(strict_types=1);

namespace App\Knowledge\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class KnowledgeController extends AbstractController
{
    #[Route(
        '/kennisbank',
        name: 'knowledge_index',
        methods: ['GET'],
    )]
    public function index(): Response
    {
        $categories = [
            [
                'slug' => 'ademhaling',
                'title' => 'Ademhaling',
                'description' => 'Over neusademhaling, mondademhaling, functioneel ademen en de relatie met mond- en kaakontwikkeling.',
            ],
            [
                'slug' => 'slaap',
                'title' => 'Slaap & snurken',
                'description' => 'Informatie over snurken, slaapkwaliteit, slaapgerelateerde ademhalingsproblemen en vermoeidheid.',
            ],
            [
                'slug' => 'kinderen',
                'title' => 'Kinderen',
                'description' => 'Signalen rond groei, mondhouding, slaap, ademhaling en ontwikkeling bij kinderen.',
            ],
            [
                'slug' => 'orthodontie',
                'title' => 'Orthodontie',
                'description' => 'Over kaakontwikkeling, beet, kaakverbreding en de rol van orthodontie binnen een bredere aanpak.',
            ],
            [
                'slug' => 'kaakchirurgie',
                'title' => 'Kaakchirurgie',
                'description' => 'Wanneer kaakchirurgische beoordeling of behandeling onderdeel kan zijn van het behandeltraject.',
            ],
            [
                'slug' => 'wetenschap',
                'title' => 'Wetenschap',
                'description' => 'Achtergrondinformatie en onderzoek over ademhaling, slaap en craniofaciale ontwikkeling.',
            ],

            [
                'slug' => 'Hypoxie',
                'title' => 'Gebrekkige zuurstofopname (Hypoxie)',
                'description' => 'Chronische mondademhaling en slaapapneu leiden direct tot een verminderde en gefragmenteerde zuurstofopname, ook wel een hypoxische micro-omgeving genoemd.',
            ],

            [
                'slug' => 'auto-immuunziekten',
                'title' => 'Auto-immuunziekten',
                'description' => 'Hypoxie verstoort de balans tussen T-helpercellen (Th17, die ontstekingen aanjagen) en regulatoire T-cellen (Tregs, die het immuunsysteem remmen). Dit heft de immuuntolerantie op.',
            ],

            [
                'slug' => 'anatomisch',
                'title' => 'Anatomisch',
                'description' => 'Een smalle bovenkaak zorgt vaak voor te weinig ruimte voor de tanden, een hoog gehemelte en een verminderde neusademhaling.',
            ],
        ];

        $featuredArticles = [
            [
                'slug' => 'wat-is-airway-orthodontics',
                'title' => 'Wat is Airway Orthodontics?',
                'excerpt' => 'Een uitleg over de samenhang tussen orthodontie, ademhaling, slaap en kaakontwikkeling.',
                'category' => 'Orthodontie',
            ],
            [
                'slug' => 'waarom-neusademhaling-belangrijk-is',
                'title' => 'Waarom neusademhaling belangrijk is',
                'excerpt' => 'Wat neusademhaling betekent voor mondfunctie, slaap en ontwikkeling.',
                'category' => 'Ademhaling',
            ],
            [
                'slug' => 'snurken-bij-kinderen',
                'title' => 'Snurken bij kinderen',
                'excerpt' => 'Wanneer snurken onschuldig kan zijn en wanneer verder onderzoek verstandig is.',
                'category' => 'Kinderen',
            ],
            [
                'slug' => 'mondademhaling-bij-kinderen',
                'title' => 'Mondademhaling bij kinderen',
                'excerpt' => 'Hoe u chronische mondademhaling herkent en waarom de oorzaak belangrijk is.',
                'category' => 'Kinderen',
            ],
            [
                'slug' => 'smalle-bovenkaak',
                'title' => 'Wat betekent een smalle bovenkaak?',
                'excerpt' => 'Over groei, beet, beschikbare ruimte en mogelijke behandelopties.',
                'category' => 'Orthodontie',
            ],
            [
                'slug' => 'wordt-airway-behandeling-vergoed',
                'title' => 'Wordt een behandeling vergoed?',
                'excerpt' => 'Een eerste uitleg over orthodontie, aanvullende verzekeringen en medisch-specialistische zorg.',
                'category' => 'Vergoeding',
            ],
        ];

        return $this->render('knowledge/index.html.twig', [
            'categories' => $categories,
            'featuredArticles' => $featuredArticles,
        ]);
    }
}