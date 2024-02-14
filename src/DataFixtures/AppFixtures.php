<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Creation of basic admin
        $manager->persist(
            (new User())
                ->setEmail('admin@admin.admin')
                ->setRoles(['ROLE_ADMIN'])
                ->setPassword('$2y$13$mm23QXQzXbNnVXgyFyFDoOJQF2.0tQHy.NbLHwQl248Kck0Gacm6G')
                // Unhashed password: adminadmin
        );

        // Creation of basic categories
        $manager->persist(
            (new Category())
                ->setName('Billet de banque')
                ->setDescription('Un billet de banque, ou monnaie-papier, est un morceau de papier ayant, par convention, une valeur économique.')
        );
        $manager->persist(
            (new Category())
                ->setName('Billet de collection')
                ->setDescription('Un billet de collection est un billet de banque qui n\'est plus en circulation ou qui ne l\'a jamais été, et qui est recherché par les collectionneurs.')
        );
        $manager->persist(
            (new Category())
                ->setName('Pièce de monnaie')
                ->setDescription('Une pièce de monnaie est un objet servant à représenter une valeur économique, généralement une unité monétaire. Sa valeur est souvent moindre que celle d\'un billet.')
        );
        $manager->persist(
            (new Category())
                ->setName('Pièce de collection')
                ->setDescription('Une pièce de collection est une pièce de monnaie qui n\'est plus en circulation ou qui ne l\'a jamais été, et qui est recherchée par les collectionneurs.')
        );
        $manager->persist(
            (new Category())
                ->setName('Ancienne monnaie')
                ->setDescription('Nous considérons comme anciennes monnaies les pièces et billets d\'une monnaie qui n\'est plus officiellement utilisable.')
        );


        $manager->flush();
    }
}
