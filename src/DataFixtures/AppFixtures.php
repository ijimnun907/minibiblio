<?php

namespace App\DataFixtures;

use App\Factory\AutorFactory;
use App\Factory\EditorialFactory;
use App\Factory\LibroFactory;
use App\Factory\SocioFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        AutorFactory::createMany(20);
        EditorialFactory::createMany(10);
        SocioFactory::createMany(40);
        LibroFactory::createMany(20, function (){
            return [
                'autores' => AutorFactory::randomRange(1,3),
                'socio' => LibroFactory::faker()->boolean(50)
                ? SocioFactory::random()
                : null,
                'editorial' => LibroFactory::faker()->boolean(50)
                ? EditorialFactory::random()
                : null
            ];
        });

        $manager->flush();
    }
}
