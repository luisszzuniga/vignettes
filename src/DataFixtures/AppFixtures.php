<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        //Création d'un admin
        $user = new User();
        $user->setEmail('admin@admin.com');
        $user->setPassword(
            $this->passwordHasher->hashPassword(
                $user,
                'password'
            )
        );
        $user->setFirstName('Admin first name');
        $user->setLastName('Admin last name');
        $user->setRoles([User::ROLE_ADMIN]);
        $user->setValidated(true);

        $manager->persist($user);

        $manager->flush();
    }
}
