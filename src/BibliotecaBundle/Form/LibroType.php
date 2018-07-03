<?php

namespace BibliotecaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
//use Symfony\Component\Form\Extension\Core\Type\Expanded;

class LibroType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('titulo', TextType::class)
          ->add('isbn', TextType::class)
          ->add('edicion', TextType::class)
          ->add('descripcion', TextareaType::class)
          ->add('editorial', TextType::class)
          ->add('foto', TextType::class)
          ->add('categorias',EntityType::class, [
              'class'=> 'BibliotecaBundle:Categoria',
              'multiple' => true
            ])
          ->add('autores',EntityType::class, [
              'class'=> 'BibliotecaBundle:Autor',
              'multiple' => true
            ])
          ->add('idioma', EntityType::class, [
              'class'=> 'BibliotecaBundle:Idioma'
            ])
          ->add('guardar', SubmitType::class)
        ;

        /*
        $builder->add('genre', EntityType::class, array(
   'class' => 'MyBundle:Genre',
   'choice_label' => 'translations[en].name',
));
        */
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BibliotecaBundle\Entity\Libro'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bibliotecabundle_libro';
    }


}
