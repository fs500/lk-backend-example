<?php

namespace App\Form\Admin;

use App\Entity\Offer;
use Eyetronic\AjaxUploaderBundle\Form\Type\AjaxFileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('iconFile', AjaxFileType::class, [
                'label' => 'Иконка',
                'by_reference' => false,
                'show_thumbnail' => true,
                'enable_delete' => true,
            ])
            ->add('header', null, [
                'label' => 'Заголовок',
            ])
            ->add('description', null, [
                'label' => 'Краткое описание',
            ])
            ->add('text', null, [
                'label' => 'Полное описание',
            ])
            ->add('deadline', DateType::class, [
                'label' => 'Срок окончания акции',
                'widget' => 'single_text',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}
