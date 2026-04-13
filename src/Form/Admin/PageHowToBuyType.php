<?php


namespace App\Form\Admin;


use App\Entity\Page;
use Eyetronic\AjaxUploaderBundle\Form\Type\AjaxFileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageHowToBuyType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('header', null, [
                'label' => 'Заголовок, первая линия'
            ])
            ->add('subHeader1', null, [
                'label' => 'Заголовок, вторая линия'
            ])
            ->add('imageFile1', AjaxFileType::class, [
                'label' => 'Фотография слева',
                'by_reference' => false,
                'show_thumbnail' => true,
                'enable_delete' => true,
            ])
            ->add('terms', CollectionType::class, [
                'label' => 'Условия покупки',
                'entry_type' => PageTermsType::class,
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
            ->add('subHeader2', null, [
                'label' => 'Заголовок (порядок покупки)'
            ])
            ->add('subHeader3', null, [
                'label' => 'Подзаголовок (порядок покупки)'
            ])
            ->add('howTos', CollectionType::class, [
                'label' => 'Порядок покупки',
                'entry_type' => PageHowToTermsType::class,
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
            ->add('subHeader4', null, [
                'label' => 'Подзаголовок (блок "забронировать")',
            ])
            ->add('imageFile2', AjaxFileType::class, [
                'label' => 'Фотография слева(блок "забронировать")',
                'by_reference' => false,
                'show_thumbnail' => true,
                'enable_delete' => true,
            ])
            ->add('howToReservations', CollectionType::class, [
                'label' => 'Порядок бронирования',
                'entry_type' => PageHowToReservationType::class,
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
            ->add('subHeader5', null, [
                'label' => 'Подзаголовок (блок "список банков")',
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