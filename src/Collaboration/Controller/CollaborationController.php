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
                        'name' => 'Dr. med. dent. Alexander Alink',
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

    #[Route('/samenwerking/zorgprofessional-worden', name: 'collaboration_professional_index', methods: ['GET'])]
    public function professionalIndex(): Response
    {
        return $this->render('collaboration/professional/index.html.twig', [
            'professions' => $this->professions(),
        ]);
    }

    #[Route('/samenwerking/zorgprofessional-worden/tandarts', name: 'collaboration_professional_dentist', methods: ['GET'])]
    public function dentist(): Response
    {
        return $this->renderProfession('tandarts');
    }

    #[Route('/samenwerking/zorgprofessional-worden/fysiotherapeut', name: 'collaboration_professional_physiotherapist', methods: ['GET'])]
    public function physiotherapist(): Response
    {
        return $this->renderProfession('fysiotherapeut');
    }

    #[Route('/samenwerking/zorgprofessional-worden/logopedist', name: 'collaboration_professional_speechTherapist', methods: ['GET'])]
    public function speechTherapist(): Response
    {
        return $this->renderProfession('logopedist');
    }

    #[Route('/samenwerking/zorgprofessional-worden/kno-arts', name: 'collaboration_professional_entSpecialist', methods: ['GET'])]
    public function entSpecialist(): Response
    {
        return $this->renderProfession('kno-arts');
    }

    private function renderProfession(string $profession): Response
    {
        return $this->render('collaboration/professional/show.html.twig', [
            'profession' => $this->professions()[$profession],
            'professions' => $this->professions(),
        ]);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    private function professions(): array
    {
        return [
            'tandarts' => [
                'slug' => 'tandarts',
                'route' => 'collaboration_professional_dentist',
                'name' => 'Tandarts',
                'plural' => 'Tandartsen',
                'eyebrow' => 'Airway-zorg in de tandartspraktijk',
                'headline' => 'Herken signalen die verder gaan dan het gebit.',
                'intro' => 'Als tandarts ziet u vaak als eerste hoe mondgedrag, tongpositie, gebitsstand en kaakontwikkeling samenhangen. Binnen het Airways-zorgnetwerk leert u deze signalen herkennen en gericht samenwerken met passende disciplines.',
                'role' => 'U helpt airway-gerelateerde kenmerken vroeg te signaleren, bespreekt relevante bevindingen met de patiënt en verwijst gericht wanneer aanvullende diagnostiek of behandeling nodig is.',
                'education' => 'Via OrthoCompany krijgt u scholing in herkenning, klinische observatie en de plaats van tandheelkunde binnen de multidisciplinaire airway-zorgstraat.',
                'signals' => ['Mondademhaling of een open mondhouding', 'Smalle kaakontwikkeling of ruimtegebrek', 'Afwijkende tongrustpositie of slikpatroon', 'Slijtage, droge mond of terugkerende mondklachten'],
                'contributions' => ['Herkennen en vastleggen van relevante signalen', 'Tandheelkundige en functionele bevindingen verbinden', 'Gericht verwijzen naar orthodontie, logopedie, fysiotherapie of KNO', 'Afstemmen en terugkoppelen binnen het behandeltraject'],
            ],
            'fysiotherapeut' => [
                'slug' => 'fysiotherapeut',
                'route' => 'collaboration_professional_physiotherapist',
                'name' => 'Fysiotherapeut',
                'plural' => 'Fysiotherapeuten',
                'eyebrow' => 'Ademhaling, functie en herstel',
                'headline' => 'Breng ademhalingspatronen en functioneren samen.',
                'intro' => 'Ademhaling staat niet los van houding, belastbaarheid, slaap en herstel. Als fysiotherapeut kunt u functionele patronen herkennen, patiënten begeleiden en binnen de Airways-zorgstraat samenwerken met tandheelkundige en medische professionals.',
                'role' => 'U observeert ademhalingsgedrag en functionele beperkingen, begeleidt verandering waar dat binnen uw expertise past en stemt af wanneer anatomische, tandheelkundige of medische beoordeling nodig is.',
                'education' => 'U krijgt educatie in het herkennen van airway-gerelateerde signalen en in praktisch samenwerken en verwijzen binnen de multidisciplinaire zorgstraat.',
                'signals' => ['Overwegend mondademen of hoog ademen', 'Moeite met neusademhaling tijdens rust of inspanning', 'Vermoeidheid, verstoord herstel of slaapsignalen', 'Spanning en compensatie rond nek, kaak of ademhaling'],
                'contributions' => ['Functionele ademhalingspatronen observeren', 'Begeleiden binnen de eigen professionele expertise', 'Signaleren wanneer aanvullende diagnostiek nodig is', 'Voortgang afstemmen met betrokken behandelprofessionals'],
            ],
            'logopedist' => [
                'slug' => 'logopedist',
                'route' => 'collaboration_professional_speechTherapist',
                'name' => 'Logopedist',
                'plural' => 'Logopedisten',
                'eyebrow' => 'Oro-myofunctionele functie',
                'headline' => 'Geef mondfunctie een herkenbare plek in de zorgstraat.',
                'intro' => 'Tongfunctie, slikken, lipgebruik en mondgedrag beïnvloeden elkaar en kunnen relevant zijn voor kaakontwikkeling en stabiliteit van een behandelresultaat. Binnen het Airways-netwerk brengt u deze functies gericht in kaart.',
                'role' => 'U beoordeelt en begeleidt oro-myofunctionele functies binnen uw vakgebied en werkt samen wanneer orthodontische, tandheelkundige, fysiotherapeutische of medische factoren een rol spelen.',
                'education' => 'De samenwerking richt zich op een gedeelde taal voor signalering, duidelijke verwijscriteria en afstemming rond timing en doelen van de begeleiding.',
                'signals' => ['Afwijkende tongrustpositie', 'Onvolwassen of afwijkend slikpatroon', 'Open mondgedrag en onvoldoende lipsluiting', 'Functionele terugval tijdens of na orthodontische behandeling'],
                'contributions' => ['Oro-myofunctionele functies onderzoeken', 'Mondgedrag, slikken en tongfunctie begeleiden', 'Behandeldoelen en timing multidisciplinair afstemmen', 'Bijdragen aan functionele stabiliteit op langere termijn'],
            ],
            'kno-arts' => [
                'slug' => 'kno-arts',
                'route' => 'collaboration_professional_entSpecialist',
                'name' => 'KNO-arts',
                'plural' => 'KNO-artsen',
                'eyebrow' => 'Medische beoordeling van de luchtweg',
                'headline' => 'Verbind medische diagnostiek met functionele zorg.',
                'intro' => 'Een belemmerde neus- of bovenste luchtweg kan van invloed zijn op ademhaling, slaap en functioneren. Als KNO-arts biedt u medische beoordeling en behandeling waar geïndiceerd, in afstemming met de andere disciplines.',
                'role' => 'U beoordeelt de neus en bovenste luchtweg, bepaalt of medische diagnostiek of behandeling geïndiceerd is en koppelt bevindingen gericht terug aan verwijzers en behandelpartners.',
                'education' => 'De samenwerking krijgt vorm via heldere verwijslijnen, relevante klinische informatie vooraf en praktische afspraken over terugkoppeling en vervolgzorg.',
                'signals' => ['Aanhoudende neusobstructie of beperkte neuspassage', 'Terugkerende mondademhaling ondanks functionele begeleiding', 'Snurken of signalen van slaapgerelateerde ademhalingsproblemen', 'Vermoeden van anatomische of inflammatoire belemmering'],
                'contributions' => ['Medische beoordeling van neus en bovenste luchtweg', 'Aanvullende diagnostiek indiceren waar nodig', 'Medisch behandelen binnen de eigen expertise', 'Gericht terugverwijzen en afstemmen over vervolgzorg'],
            ],
        ];
    }
}
