<?php

namespace App\Form\Admin;

use App\Entity\Flat;
use App\Entity\Floor;
use Eyetronic\AjaxUploaderBundle\Form\Type\AjaxFileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FlatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('floor', EntityType::class, [
                'label' => 'Этаж',
                'class' => Floor::class
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Статус',
                'choices' => array_flip(Flat::getStatusChoices()),
                'placeholder' => 'Выберите статус квартиры'
            ])
            ->add('number', null, [
                'label' => 'Номер',
            ])
            ->add('planFile', AjaxFileType::class, [
                'label' => 'Планировка',
                'by_reference' => false,
                'show_thumbnail' => true,
                'enable_delete' => true,
            ])
            ->add('plan3dFile', AjaxFileType::class, [
                'label' => '3D Планировка',
                'by_reference' => false,
                'show_thumbnail' => true,
                'enable_delete' => true,
            ])
            ->add('planUrl', null, [
                'label' => 'URL 3d планировки'
            ])
            ->add('rooms', ChoiceType::class, [
                'label' => 'Комнатность',
                'choices' => array_flip(Flat::getRoomsChoices()),
                'placeholder' => 'Выберите количество комнат'
            ])
            ->add('area', null, [
                'label' => 'Общая площадь',
            ])
            ->add('roomsArea', null, [
                'label' => 'Площадь комнат',
            ])
            ->add('kitchenArea', null, [
                'label' => 'Площадь кухни',
            ])
            ->add('ceilingHeight', null, [
                'label' => 'Высота потолков',
            ])
            ->add('price', null, [
                'label' => 'Цена',
            ])
            ->add('priceM', null, [
                'label' => 'Цена за метр',
            ])
            ->add('priceFinish', null, [
                'label' => 'Цена c отделкой',
            ])
            ->add('priceFinishM', null, [
                'label' => 'Цена c отделкой за метр',
            ])
            ->add('priceAction', null, [
                'label' => 'Цена по акции',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Flat::class,
        ]);
    }
}
