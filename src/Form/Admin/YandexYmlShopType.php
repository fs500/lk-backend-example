<?php

namespace App\Form\Admin;

use App\Entity\YandexYmlCurrency;
use App\Entity\YandexYmlShop;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class YandexYmlShopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => 'Название',
            ])
            ->add('url', TextType::class, [
                'label' => 'Сайт',
            ])
            ->add('company', null, [
                'label' => 'Компания',
            ])
            ->add('email', null, [
                'label' => 'Email',
            ])
            ->add('currency', EntityType::class, [
                'label' => 'Идентификатор валюты',
                'class' => YandexYmlCurrency::class,
                'placeholder' => 'Выберите значение',
            ])
            ->add('paramConversion', null, [
                'label' => 'Конверсия',
            ])
            ->add('paramOfferType', ChoiceType::class, [
                'label' => 'Тип предложения',
                'placeholder' => 'Выберите значение',
                'choices' => array_flip(YandexYmlShop::getOfferTypeChoices())
            ])
            ->add('vendor', null, [
                'label' => 'Застройщик',
            ])
            ->add('description', null, [
                'label' => 'Описание',
            ])
            ->add('paramBuilderUrl', TextType::class, [
                'label' => 'Сайт застройщика',
                'required' => false
            ])
            ->add('paramMinMortgage', null, [
                'label' => 'Минимальная ипотека',
            ])
            ->add('paramEstateType', ChoiceType::class, [
                'label' => 'Рынок жилья',
                'placeholder' => 'Выберите значение',
                'choices' => array_flip(YandexYmlShop::getEstateTypeChoices()),
                'required' => false
            ])
            ->add('paramEstateClass', ChoiceType::class, [
                'label' => 'Класс недвижимости',
                'placeholder' => 'Выберите значение',
                'multiple' => true,
                'expanded' => true,
                'choices' => array_flip(YandexYmlShop::getEstateClassChoices()),
                'required' => false
            ])
            ->add('paramAddress', null, [
                'label' => 'Адрес',
            ])
            ->add('paramLatitude', TextType::class, [
                'label' => 'Широта на карте',
            ])
            ->add('paramLongitude', TextType::class, [
                'label' => 'Долгота на карте',
            ])
            ->add('paramBuiltYear', null, [
                'label' => 'Год постройки',
            ])
            ->add('paramTotalFloor', null, [
                'label' => 'Всего этажей',
            ])
            ->add('paramSubwayDistance', null, [
                'label' => 'Расстояние до метро (минут)',
            ])
            ->add('paramSubwayDistanceUnit', ChoiceType::class, [
                'label' => 'Расстояние до метро (тип)',
                'placeholder' => 'Выберите значение',
                'choices' => array_flip(YandexYmlShop::getSubwayDistanceUnitChoices()),
                'required' => false
            ])
            ->add('paramParkingType', ChoiceType::class, [
                'label' => 'Тип парковки',
                'placeholder' => 'Выберите значение',
                'multiple' => true,
                'expanded' => true,
                'choices' => array_flip(YandexYmlShop::getParkingTypeChoices())
            ])
            ->add('paramFinishing', ChoiceType::class, [
                'label' => 'Отделка',
                'placeholder' => 'Выберите значение',
                'multiple' => true,
                'expanded' => true,
                'choices' => array_flip(YandexYmlShop::getFinishingChoices())
            ])
            ->add('paramRepair', ChoiceType::class, [
                'label' => 'Ремонт',
                'placeholder' => 'Выберите значение',
                'choices' => array_flip(YandexYmlShop::getRepairChoices()),
                'required' => false
            ])
            ->add('paramSite', null, [
                'label' => 'Сайт объекта',
            ])
            ->add('paramPhone', null, [
                'label' => 'Телефон',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => YandexYmlShop::class,
            'csrf_protection' => false
        ]);
    }
}
