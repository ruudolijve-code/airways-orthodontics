<?php

declare(strict_types=1);

namespace App\Command;

use App\Security\Entity\User;
use App\Security\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-admin',
    description: 'Maakt een nieuwe beheerder aan voor Airways Orthodontics.',
)]
final class CreateAdminCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
        parent::__construct();
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output,
    ): int {
        $helper = $this->getHelper('question');

        $emailQuestion = new Question('E-mailadres: ');
        $emailQuestion->setValidator(
            static function (?string $email): string {
                $email = mb_strtolower(trim((string) $email));

                if ($email === '') {
                    throw new \RuntimeException(
                        'E-mailadres is verplicht.',
                    );
                }

                if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                    throw new \RuntimeException(
                        'Voer een geldig e-mailadres in.',
                    );
                }

                return $email;
            },
        );

        /** @var string $email */
        $email = $helper->ask(
            $input,
            $output,
            $emailQuestion,
        );

        if ($this->userRepository->findOneBy(['email' => $email]) !== null) {
            $output->writeln(
                '<error>Er bestaat al een gebruiker met dit e-mailadres.</error>',
            );

            return Command::FAILURE;
        }

        $firstNameQuestion = new Question('Voornaam: ');
        $lastNameQuestion = new Question('Achternaam: ');

        /** @var string|null $firstName */
        $firstName = $helper->ask(
            $input,
            $output,
            $firstNameQuestion,
        );

        /** @var string|null $lastName */
        $lastName = $helper->ask(
            $input,
            $output,
            $lastNameQuestion,
        );

       $passwordQuestion = new Question('Wachtwoord: ');
        $passwordQuestion->setHidden(true);
        $passwordQuestion->setHiddenFallback(false);
        $passwordQuestion->setValidator(
            static function (?string $password): string {
                $password = (string) $password;

                if (mb_strlen($password) < 12) {
                    throw new \RuntimeException(
                        'Het wachtwoord moet minimaal 12 tekens bevatten.',
                    );
                }

                return $password;
            },
        );

        /** @var string $plainPassword */
        $plainPassword = $helper->ask(
            $input,
            $output,
            $passwordQuestion,
        );

        $user = new User();

        $user
            ->setEmail($email)
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setRoles(['ROLE_ADMIN'])
            ->setIsActive(true);

        $user->setPassword(
            $this->passwordHasher->hashPassword(
                $user,
                $plainPassword,
            ),
        );

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln('');
        $output->writeln(
            sprintf(
                '<info>Admin-gebruiker %s is succesvol aangemaakt.</info>',
                $email,
            ),
        );

        return Command::SUCCESS;
    }
}