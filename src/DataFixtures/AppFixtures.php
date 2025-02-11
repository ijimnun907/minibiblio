<?php

namespace App\DataFixtures;

use App\Entity\Socio;
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

        AutorFactory::createMany(200);
        EditorialFactory::createMany(100);

        SocioFactory::createOne([
            'dni' => SocioFactory::faker()->unique()->dni(),
            'nombre' => 'admin',
            'apellidos' => 'admin',
            'esAdministrador' => true,
            'email' => 'admin@biblio.local',
            'clave' => 'admin',  // Se codificará en el Factory
            'esDocente' => false,
            'esEstudiante' => false
        ]);

        // Crear un socio DOCENTE
        SocioFactory::createOne([
            'dni' => SocioFactory::faker()->unique()->dni(),
            'nombre' => 'docente',
            'apellidos' => 'docente',
            'esAdministrador' => false,
            'email' => 'docente@biblio.local',
            'clave' => 'docente',
            'esDocente' => true,
            'esEstudiante' => false
        ]);

        // Crear un socio ESTUDIANTE
        SocioFactory::createOne([
            'dni' => SocioFactory::faker()->unique()->dni(),
            'nombre' => 'estudiante',
            'apellidos' => 'estudiante',
            'esAdministrador' => false,
            'email' => 'estudiante@biblio.local',
            'clave' => 'estudiante',
            'esDocente' => false,
            'esEstudiante' => true
        ]);
        SocioFactory::createMany(20);
        LibroFactory::createMany(50, function (){
            return [
                'autores' => AutorFactory::randomRange(1,3),
                'socio' => LibroFactory::faker()->boolean(25)
                ? SocioFactory::random()
                : null,
                'editorial' => EditorialFactory::random()
            ];
        });

        $manager->flush();
    }
}
