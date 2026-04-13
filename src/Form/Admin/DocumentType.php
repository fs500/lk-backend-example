<?php

namespace App\Form\Admin;

use App\Entity\Document;
use Eyetronic\AjaxUploaderBundle\Form\Type\AjaxFileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, [
                'label' => 'Дата документа',
                'widget' => 'single_text'
            ])
            ->add('name', null, [
                'label' => 'Имя менеджера',
            ])
            ->add('header', null, [
                'label' => 'Название документа',
            ])
            ->add('uploadedFile', AjaxFileType::class, [
                'label' => 'Файл',
                'by_reference' => false,
                'enable_delete' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Document::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ]
        ]);
    }
}
