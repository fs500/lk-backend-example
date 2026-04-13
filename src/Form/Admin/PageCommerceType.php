<?php


namespace App\Form\Admin;


use App\Entity\Page;
use Eyetronic\AjaxUploaderBundle\Form\Type\AjaxFileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageCommerceType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('header', null, [
                'label' => 'Заголовок'
            ])
            ->add('subHeader1', null, [
                'label' => 'Заголовок слева'
            ])
            ->add('imageFile1', AjaxFileType::class, [
                'label' => 'Фотография слева',
                'by_reference' => false,
                'show_thumbnail' => true,
                'enable_delete' => true,
            ])
            ->add('subHeader2', null, [
                'label' => 'Заголовок справа'
            ])
            ->add('imageFile2', AjaxFileType::class, [
                'label' => 'Фотография справа',
                'by_reference' => false,
                'show_thumbnail' => true,
                'enable_delete' => true,
            ])
            ->add('subHeader3', null, [
                'label' => 'Подзаголовок (инвестиции)'
            ])
            ->add('text', null, [
                'label' => 'Текст (инвестиции)'
            ])
            ->add('images', CollectionType::class,[
                'label' => 'Характеристики помещений',
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ]
        ]);
    }
}