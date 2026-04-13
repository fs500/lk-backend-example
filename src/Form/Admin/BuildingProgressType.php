<?php

namespace App\Form\Admin;

use App\Entity\BuildingProgress;
use App\Entity\Project;
use App\Entity\ProjectQueue;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BuildingProgressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Дата',
            ])
            ->add('description', null, [
                'label' => 'Краткое описание'
            ])
            ->add('items', CollectionType::class, [
                'label' => 'Фотографии',
                'entry_type' => BuildingProgressItemType::class,
                'entry_options' => [
                    'label' => false
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'row_attr' => [
                    'class' => 'sortable-container'
                ],
                'block_prefix' => 'ajax_image_collection'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => BuildingProgress::class,
                'attr' => [
                    'novalidate' => 'novalidate'
                ],
            ])
        ;
    }
}
