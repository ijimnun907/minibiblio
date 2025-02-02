<?php

namespace App\Form;

use App\Entity\Autor;
use App\Entity\Editorial;
use App\Entity\Libro;
use App\Entity\Socio;
use App\Repository\AutorRepository;
use App\Repository\EditorialRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LibroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo', TextType::class)
            ->add('anioPublicacion')
            ->add('paginas', IntegerType::class)
            ->add('isbn', TextType::class)
            ->add('precioCompra', MoneyType::class, [
                'divisor' => 100
            ])
            ->add('editorial', EntityType::class, [
                'class' => Editorial::class,
                'multiple' => false,
                'required' => false,
                'choice_label' => 'nombre',
                'query_builder' => function (EditorialRepository $editorialRepository) {
                    return $editorialRepository->createQueryBuilder('e')
                        ->orderBy('e.nombre');
                }
            ])
            ->add('autores', EntityType::class, [
                'class' => Autor::class,
                'multiple' => true,
                'required' => false,
                'query_builder' => function (AutorRepository $autorRepository) {
                    return $autorRepository->createQueryBuilder('a')
                        ->orderBy('a.nombre')
                        ->addOrderBy('a.apellidos');
                }
            ])
            ->add('socio', EntityType::class, [
                'class' => Socio::class,
                'multiple' => false,
                'required' => false,
                'placeholder' => 'No prestado',
                'choice_label' => function (Socio $socio) {
                    return $socio->__toString() . ($socio->isEsDocente() ? '(docente)': '');
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Libro::class,
        ]);
    }
}
