<?php

namespace App\Form\Admin;

use App\Entity\Flat;
use App\Entity\YandexYmlOffer;
use App\Entity\YandexYmlShop;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class YandexYmlOfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('shop', null, [
                'label' => 'Фид',
                'placeholder' => null
            ])
            ->add('flat', null, [
                'label' => 'Квартира',
            ])
            ->add('name', null, [
                'label' => 'Название',
            ])
            ->add('category', null, [
                'label' => 'Категория',
            ])
            ->add('sets', null, [
                'label' => 'Сеты',
                'expanded' => true
            ])
            ->add('paramConversion', null, [
                'label' => 'Конверсия',
            ])
            ->add('paramFreePlan', null, [
                'label' => 'Свободная планировка',
            ])
            ->add('description', null, [
                'label' => 'Описание',
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => YandexYmlOffer::class,
        ]);
    }
}
