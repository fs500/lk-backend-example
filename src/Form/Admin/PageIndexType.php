<?php

namespace App\Form\Admin;

use App\Entity\Page;
use Eyetronic\AjaxUploaderBundle\Form\Type\AjaxFileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageIndexType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('slides', CollectionType::class, [
                'label' => 'Слайды',
                'entry_type' => PageSlideType::class,
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
            ->add('header', null, [
                'label' => 'Заголовок',
            ])
            ->add('text', null, [
                'label' => 'Текст',
            ])
            ->add('imageFile1', AjaxFileType::class, [
                'label' => 'Фотография слева',
                'by_reference' => false,
                'show_thumbnail' => true,
                'enable_delete' => true,
            ])
            ->add('imageFile2', AjaxFileType::class, [
                'label' => 'Фотография справа',
                'by_reference' => false,
                'show_thumbnail' => true,
                'enable_delete' => true,
            ])
            ->add('subHeader1', null, [
                'label' => 'Заголовок (8 причин купить квартиру, первая линия)',
            ])
            ->add('subHeader2', null, [
                'label' => 'Заголовок (8 причин купить квартиру, вторая линия)',
            ])
            ->add('images', CollectionType::class,[
                'label' => 'Галерея',
                'entry_type' => PageIndexImageType::class,
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
            ->add('subHeader3', null, [
                'label' => 'Заголовок (в блоке квартир)',
            ])
            ->add('link', LinkType::class, [
                'label' => 'Ссылка на выборщик (в списке квартир)'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
            'csrf_protection' => false,
            'attr' => [
                'novalidate' => 'novalidate',
            ]
        ]);
    }
}
