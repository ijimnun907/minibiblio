<?php

namespace App\Repository;

use App\Entity\Libro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Libro>
 *
 * @method Libro|null find($id, $lockMode = null, $lockVersion = null)
 * @method Libro|null findOneBy(array $criteria, array $orderBy = null)
 * @method Libro[]    findAll()
 * @method Libro[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LibroRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Libro::class);
    }

    public function findLibrosOrdenadosOrdenAlfabetico() : array
    {
        return $this->getEntityManager()
            ->createQuery("SELECT l FROM App\Entity\Libro l ORDER BY l.titulo")
            ->getResult();
    }

    public function findLibrosAnioDescendente() : array
    {
        return $this->getEntityManager()
            ->createQuery("SELECT l FROM App\Entity\Libro l ORDER BY l.anioPublicacion DESC")
            ->getResult();
    }

    public function findLibrosConPalabra(string $palabra) : array
    {
        return $this->getEntityManager()
            ->createQuery("SELECT l FROM App\Entity\Libro l WHERE l.titulo LIKE :palabra")
            ->setParameter('palabra', '%' . $palabra . '%')
            ->getResult();
    }

    public function findLibrosEditorialNoContenieneLetra() : array
    {
        $letra = "a";
        return $this->getEntityManager()
            ->createQuery("SELECT l, e FROM App\Entity\Libro l JOIN l.editorial e WHERE e.nombre NOT LIKE :letra")
            ->setParameter('letra', '%' . $letra . '%')
            ->getResult();
    }

    public function findLibrosConUnAutor() : array
    {
        return $this->getEntityManager()
            ->createQuery("SELECT l FROM App\Entity\Libro l WHERE SIZE(l.autores) = :numero")
            ->setParameter('numero', 1)
            ->getResult();
    }

//    /**
//     * @return Libro[] Returns an array of Libro objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Libro
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
