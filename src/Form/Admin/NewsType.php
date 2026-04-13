<?php

namespace App\Form\Admin;

use App\Entity\News;
use Eyetronic\AjaxUploaderBundle\Form\Type\AjaxFileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('header', null, [
                'label' => 'Заголовок',
                'attr' => [
                    'class' => 'translation_source'
                ]
            ])
            ->add('path', null, [
                'label' => 'Путь',
                'attr' => [
                    'class' => 'translation_destination'
                ]
            ])
            ->add('date', DateType::class, [
                'label' => 'Дата',
                'widget' => 'single_text',
            ])
            ->add('description', null, [
                'label' => 'Краткое описание',
                'attr' => [
                    'rows' => 4
                ]
            ])
            ->add('text', null, [
                'label' => 'Текст',
                'attr' => [
                    'rows' => 6
                ]
            ])
            ->add('imageFile', AjaxFileType::class, [
                'label' => 'Фотография',
                'show_thumbnail' => true,
                'enable_delete' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => News::class,
            'csrf_protection' => false,
            'attr' => [
                'novalidate' => 'novalidate'
            ]
        ]);
    }
}
