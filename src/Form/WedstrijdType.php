<?php

namespace App\Form;

use App\Entity\Wedstrijd;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WedstrijdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ronde')
            ->add('score1')
            ->add('score2')
            ->add('tornooi')
            ->add('speler1')
            ->add('speler2')
            ->add('winnaar')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Wedstrijd::class,
        ]);
    }
}
