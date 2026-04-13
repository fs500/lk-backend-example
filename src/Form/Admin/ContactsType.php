<?php

namespace App\Form\Admin;

use App\Entity\Contacts;
use Eyetronic\AjaxUploaderBundle\Form\Type\AjaxFileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('header', null, [
                'label' => 'Заголовок',
            ])
            ->add('subHeader', null, [
                'label' => 'Подзаголовок',
            ])
            ->add('mapLatitude', NumberType::class, [
                'label' => 'Широта (на карте)',
                'scale' => 6
            ])
            ->add('mapLongitude', NumberType::class, [
                'label' => 'Долгота (на карте)',
                'scale' => 6
            ])
            ->add('mapScale', null, [
                'label' => 'Масштаб карты',
            ])
            ->add('officeAddress', null, [
                'label' => 'Адрес офиса',
            ])
            ->add('officeImageFile', AjaxFileType::class, [
                'label' => 'Иконка офиса на карте',
                'by_reference' => false,
                'show_thumbnail' => true,
                'enable_delete' => true,
            ])
            ->add('officeLatitude', NumberType::class, [
                'label' => 'Координаты офиса (широта)',
                'scale' => 6
            ])
            ->add('officeLongitude', NumberType::class, [
                'label' => 'Координаты офиса (долгота)',
                'scale' => 6
            ])
            ->add('officeRoute', LinkType::class, [
                'label' => 'Ссылка на маршрут (для офиса)'
            ])
            ->add('objectAddress', null, [
                'label' => 'Адрес ЖК',
            ])
            ->add('objectImageFile', AjaxFileType::class, [
                'label' => 'Иконка ЖК на карте',
                'by_reference' => false,
                'show_thumbnail' => true,
                'enable_delete' => true,
            ])
            ->add('objectLatitude', NumberType::class, [
                'label' => 'Координаты ЖК (широта)',
                'scale' => 6
            ])
            ->add('objectLongitude', NumberType::class, [
                'label' => 'Координаты ЖК (долгота)',
                'scale' => 6
            ])
            ->add('objectRoute', LinkType::class, [
                'label' => 'Ссылка на маршрут (для ЖК)'
            ])
            ->add('phone', null, [
                'label' => 'Телефон',
            ])
            ->add('email', null, [
                'label' => 'Email',
            ])
            ->add('site', null, [
                'label' => 'Сайт',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contacts::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ]
        ]);
    }
}
