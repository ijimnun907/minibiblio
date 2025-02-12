<?php

namespace App\DataFixtures;

use App\Entity\Socio;
use App\Factory\AutorFactory;
use App\Factory\EditorialFactory;
use App\Factory\LibroFactory;
use App\Factory\SocioFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
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
            'clave' => $this->passwordHasher->hashPassword(new Socio(), 'admin'),
            'esDocente' => false,
            'esEstudiante' => false,
            'esBibliotecario' => false
        ]);

        SocioFactory::createOne([
            'dni' => SocioFactory::faker()->unique()->dni(),
            'nombre' => 'bibliotecario',
            'apellidos' => 'bibliotecario',
            'esAdministrador' => false,
            'email' => 'bibliotecario@biblio.local',
            'clave' => $this->passwordHasher->hashPassword(new Socio(), 'biblio'),
            'esDocente' => false,
            'esEstudiante' => false,
            'esBibliotecario' => true
        ]);

        // Crear un socio DOCENTE
        SocioFactory::createOne([
            'dni' => SocioFactory::faker()->unique()->dni(),
            'nombre' => 'docente',
            'apellidos' => 'docente',
            'esAdministrador' => false,
            'email' => 'docente@biblio.local',
            'clave' => $this->passwordHasher->hashPassword(new Socio(), 'docente'),
            'esDocente' => true,
            'esEstudiante' => false,
            'esBibliotecario' => false
        ]);

        // Crear un socio ESTUDIANTE
        SocioFactory::createOne([
            'dni' => SocioFactory::faker()->unique()->dni(),
            'nombre' => 'estudiante',
            'apellidos' => 'estudiante',
            'esAdministrador' => false,
            'email' => 'estudiante@biblio.local',
            'clave' => $this->passwordHasher->hashPassword(new Socio(), 'estudiante'),
            'esDocente' => false,
            'esEstudiante' => true,
            'esBibliotecario' => false
        ]);
        SocioFactory::createMany(20, [
            'clave' => $this->passwordHasher->hashPassword(new Socio(), 'prueba')
        ]);
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
