<?php

namespace App\Form\Admin;

use App\Entity\PageInfrastructure;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageInfrastructureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('header1', null, [
                'label' => 'Заголовок на карте (первая линия)',
            ])
            ->add('header2', null, [
                'label' => 'Заголовок на карте (вторая линия)',
            ])
            ->add('latitude', NumberType::class, [
                'label' => 'Координаты центра карты (широта)',
                'scale' => 6
            ])
            ->add('longitude', NumberType::class, [
                'label' => 'Координаты центра карты (долгота)',
                'scale' => 6
            ])
            ->add('scale', null, [
                'label' => 'Масштаб карты',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PageInfrastructure::class,
        ]);
    }
}
