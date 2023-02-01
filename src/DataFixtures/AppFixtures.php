<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\GridSize;
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

        // Création des catégories
        $category = new Category();
        $category->setName('Dessin');
        $manager->persist($category);

        $category2 = new Category();
        $category2->setName('Montage');
        $manager->persist($category2);

        $gridSize = new GridSize();
        $gridSize->setGridColumn('1');
        $gridSize->setGridRow('2');
        $manager->persist($gridSize);

        $gridSize = new GridSize();
        $gridSize->setGridColumn('2');
        $gridSize->setGridRow('4');
        $manager->persist($gridSize);

        $manager->flush();
    }
}
