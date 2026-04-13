<?php

namespace App\Form\Admin;

use App\Entity\Bank;
use Eyetronic\AjaxUploaderBundle\Form\Type\AjaxFileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BankType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('logoFile', AjaxFileType::class, [
                'label' => 'Логотип',
                'by_reference' => false,
                'show_thumbnail' => true,
                'enable_delete' => true,
            ])
            ->add('header', null, [
                'label' => 'Заголовок',
            ])
            ->add('sort', null, [
                'label' => 'Сортировка',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bank::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ]
        ]);
    }
}
