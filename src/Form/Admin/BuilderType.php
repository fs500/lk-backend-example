<?php

namespace App\Form\Admin;

use App\Entity\Builder;
use Eyetronic\AjaxUploaderBundle\Form\Type\AjaxFileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BuilderType extends AbstractType
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
            ->add('text', null, [
                'label' => 'Текст',
            ])
            ->add('advantages', CollectionType::class, [
                'label' => 'Достижения',
                'entry_type' => BuilderAdvantageType::class,
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
            'data_class' => Builder::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ]
        ]);
    }
}
