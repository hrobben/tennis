<?php

namespace App\Form;

use App\Entity\Speler;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpelerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('roepnaam')
            ->add('tussenvoegsel')
            ->add('achternaam')
            ->add('school')
            ->add('tornooi')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Speler::class,
        ]);
    }
}
