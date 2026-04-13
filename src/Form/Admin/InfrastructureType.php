<?php

namespace App\Form\Admin;

use App\Entity\Infrastructure;
use Eyetronic\AjaxUploaderBundle\Form\Type\AjaxFileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InfrastructureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('header', null, [
                'label' => 'Название группы',
            ])
            ->add('iconFile', AjaxFileType::class, [
                'label' => 'Значок',
                'by_reference' => false,
                'show_thumbnail' => true,
                'enable_delete' => true,
            ])
            ->add('sort', null, [
                'label' => 'Сортировка',
            ])
            ->add('items', CollectionType::class, [
                'label' => 'Объекты группы',
                'entry_type' => InfrastructureItemType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Infrastructure::class
        ]);
    }
}
