<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Property;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $user = new User;
        $user->setEmail("contact@agency.fr")
            ->setRoles(['ROLE_SUPERADMIN', 'ROLE_ADMIN'])
            ->setPassword("password")
            ->setFirstname($faker->firstName())
            ->setLastname($faker->lastName())
            ->setPhone($faker->phoneNumber());
        $manager->persist($user);
        $manager->flush();

        for ($i=0; $i < 10; $i++) { 
            $property = new Property;
            $property->setTitle($faker->words(5, true))
                    ->setSurface($faker->randomNumber(3, false))
                    ->setContent($faker->text(300))
                    ->setPrice($faker->randomNumber(7, false))
                    ->setRooms($faker->randomNumber(1, true))
                    ->setAddress($faker->streetAddress())
                    ->setZipcode($faker->postcode())
                    ->setCity($faker->city())
                    ->setType("Maison")
                    ->setTransactionType($faker->boolean())
                    ->setGroundSize($faker->randomNumber(3, false))
                    ->setDateOfConstruction(new \Datetime($faker->date()))
                    ->setSell(false)
                    ->setEmployee($user);
            $slug = str_replace(" ", "-", $property->getTitle());
            $property->setSlug($slug);
            $manager->persist($property);
        }
        $manager->flush();
    }
}
