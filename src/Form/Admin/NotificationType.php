<?php

namespace App\Form\Admin;

use App\Entity\Notification;
use Eyetronic\AjaxUploaderBundle\Form\Type\AjaxFileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NotificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateStart', DateType::class, [
                'label' => 'Дата начала показа',
                'widget' => 'single_text',
            ])
            ->add('dateFinish', DateType::class, [
                'label' => 'Дата окончания показа',
                'widget' => 'single_text',
            ])
            ->add('imageFile', AjaxFileType::class, [
                'label' => 'Картинка',
                'show_thumbnail' => true,
                'enable_delete' => true,
                'by_reference' => false,
            ])
            ->add('header', null, [
                'label' => 'Заголовок',
            ])
            ->add('text', null, [
                'label' => 'Текст',
            ])
            ->add('buttonText', null, [
                'label' => 'Текст на кнопке',
            ])
            ->add('buttonUrl', TextType::class, [
                'label' => 'Ссылка для кнопки',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Notification::class,
            'csrf_protection' => false,
            'attr' => [
                'novalidate' => 'novalidate'
            ]
        ]);
    }
}
