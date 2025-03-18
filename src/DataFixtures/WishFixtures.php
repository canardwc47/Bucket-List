<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Wish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class WishFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $categories = $manager->getRepository(Category::class)->findAll();
        //Création d'un cours$wish = new Wish
        ////        ();
        ////        $wish->setTitle('Diplome');
        ////        $wish->setDescription('Avoir mon diplome');
        ////        $wish->setAuthor('Lucile');
        ////        $wish->setIsPublished(true);
        ////        $wish->setDateCreated(new \DateTimeImmutable('2025-01-01'));
        ////        $wish->setDateUpdated(new \DateTimeImmutable('2025-01-01'));
        ////        $manager->persist($wish);
        ////
        ////        $wish = new Wish
        ////        ();
        ////        $wish->setTitle('Alternance');
        ////        $wish->setDescription('Trouver une alternance');
        ////        $wish->setAuthor('Lucile');
        ////        $wish->setIsPublished(true);
        ////        $wish->setDateCreated(new \DateTimeImmutable('2025-01-01'));
        ////        $wish->setDateUpdated(new \DateTimeImmutable('2025-01-01'));
        ////        $manager->persist($wish);
        ////
        ////        $wish = new Wish
        ////        ();
        ////        $wish->setTitle('Vacances');
        ////        $wish->setDescription('Partir en vacances');
        ////        $wish->setAuthor('Lucile');
        ////        $wish->setIsPublished(true);
        ////        $wish->setDateCreated(new \DateTimeImmutable('2025-01-01'));
        ////        $wish->setDateUpdated(new \DateTimeImmutable('2025-01-01'));
        ////        $wish->setCategory('Others');
        ////        $manager->persist($wish);
//

        //On va paramétrer faker pour qu'il utilise des datas en français.

        $faker = \Faker\Factory::create('fr_FR');
        for ($i = 1; $i <= 30; $i++) {
            $wish = new Wish();
            $wish->setTitle($faker->name());
            $wish->setDescription($faker->realText);
            $wish->setAuthor($faker->name);
            $dateCreated = $faker->dateTimeBetween('-2 months', 'now');
            $wish->setDateCreated(\DateTimeImmutable::createFromMutable($dateCreated));
            $dateModified = $faker->dateTimeBetween($wish->getDateCreated()->format('Y-m-d'), 'now');
            $wish->setDateUpdated(\DateTimeImmutable::createFromMutable($dateModified));
            $wish->setIsPublished(true);
            $wish->setCategory($faker->randomElement($categories));
            $manager->persist($wish);
        }

//        $faker = \Faker\Factory::create('fr_FR');

//        //Création de 30 Cours Supplémentaire
//        for($i=1;$i<=30;$i++){
//            $wish = new Wish
//            ();
//            $wish->setTitle($faker->word());
//            $wish->setDescription($faker->realText);
//            $wish->setDuration(mt_rand(1,10));
//            $dateCreated=$faker->dateTimeBetween('-2 months','now');
//            $wish->setDateCreated(\DateTimeImmutable::createFromMutable($dateCreated));
//            $dateModified = $faker->dateTimeBetween($wish->getDateCreated()->format('Y-m-d'),'now');
//            $wish->setDateModified(\DateTimeImmutable::createFromMutable($dateModified));
//            $wish->setPublished(false);
//            $manager->persist($wish);
//        }


        //Création de 30 Cours Supplémentaire
        /*        for($i=1;$i<=30;$i++){
                    $wish = new Wish
        ();
                    $wish->setName("Cours $i");
                    $wish->setContent("Description du cours $i");
                    $wish->setDuration(mt_rand(1,10));
                    $wish->setDateCreated(new \DateTimeImmutable());
                    $wish->setPublished(false);
                    $manager->persist($wish);
                }*/

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class
        ];
        // TODO: Implement getDependencies() method.
    }
}
