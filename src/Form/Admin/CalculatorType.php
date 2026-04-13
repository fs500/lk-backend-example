<?php

namespace App\Form\Admin;

use App\Entity\Calculator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalculatorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('priceDefault', null, [
                'label' => 'Стоимость квартиры (по-умолчанию)',
            ])
            ->add('paymentMin', null, [
                'label' => 'Первоначальный взнос, % (минимум)',
            ])
            ->add('paymentMax', null, [
                'label' => 'Первоначальный взнос, % (максимум)',
            ])
            ->add('defaultPayment', null, [
                'label' => 'Первоначальный взнос, % (по-умолчанию)',
            ])
            ->add('yearsMin', null, [
                'label' => 'Срок кредитования, лет (минимум)',
            ])
            ->add('yearsMax', null, [
                'label' => 'Срок кредитования, лет (максимум)',
            ])
            ->add('defaultYears', null, [
                'label' => 'Срок кредитования, лет (по-умолчанию)',
            ])
            ->add('rateMin', null, [
                'label' => 'Процентная ставка (минимум)',
            ])
            ->add('rateMax', null, [
                'label' => 'Процентная ставка (максимум)',
            ])
            ->add('rateDefault', null, [
                'label' => 'Процентная ставка (по-умолчанию)',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Calculator::class,
        ]);
    }
}
