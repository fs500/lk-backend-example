<?php

namespace App\Form\Admin;

use App\Entity\Building;
use Eyetronic\AjaxUploaderBundle\Form\Type\AjaxFileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BuildingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => 'Название'
            ])
            ->add('deadline', null, [
                'label' => 'Год сдачи',
            ])
            ->add('readyQuarter', ChoiceType::class, [
                'label' => 'Квартал сдачи',
                'choices' => array_flip(Building::getReadyQuarterChoices()),
                'placeholder' => 'Выберите квартал'
            ])
            ->add('buildingState', ChoiceType::class, [
                'label' => 'Стадия строительства',
                'choices' => array_flip(Building::getBuildingStateChoices()),
                'placeholder' => 'Выберите стадию строительства'
            ])
            ->add('logoFile', AjaxFileType::class, [
                'label' => 'Логотип (для PDF)',
                'by_reference' => false,
                'show_thumbnail' => true,
                'enable_delete' => true,
            ])
            ->add('mapImageFile', AjaxFileType::class, [
                'label' => 'Изображение карты (для PDF)',
                'by_reference' => false,
                'show_thumbnail' => true,
                'enable_delete' => true,
            ])
            ->add('liveBroadcastURL', null, [
                'label' => 'Ссылка на трансляцию (для отображения на сайте)',
            ])
            ->add('qrCodeURL', null, [
                'label' => 'Ссылка на трансляцию (для генерации QR кода для PDF)',
            ])
            ->add('buildingType', ChoiceType::class, [
                'label' => 'Тип дома',
                'choices' => array_flip(Building::getBuildingTypeChoices()),
                'placeholder' => 'Выберите тип дома',
            ])
            ->add('finishType', ChoiceType::class, [
                'label' => 'Тип отделки',
                'choices' => array_flip(Building::getFinishTypeChoices()),
                'placeholder' => 'Выберите тип отделки'
            ])
            ->add('placements', CollectionType::class, [
                'label' => 'Расположение',
                'entry_type' => BuildingPlacementType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'row_attr' => [
                    'class' => 'sortable-container'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Building::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ]
        ]);
    }
}
