<?php


namespace App\Form\Admin;


use App\Entity\Page;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageLocationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('header', null, [
                'label' => 'Заголовок',
            ])
            ->add('subHeader1', TextType::class, [
                'label' => 'Адрес на карте (первая строчка)',
                'required' => false,
            ])
            ->add('subHeader2', TextType::class, [
                'label' => 'Адрес на карте (вторая строчка)',
                'required' => false,
            ])
            ->add('howTos', CollectionType::class, [
                'label' => 'Как добраться',
                'entry_type' => PageHowToType::class,
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
            'csrf_protection' => false,
            'attr' => [
                'novalidate' => 'novalidate'
            ]
        ]);
    }
}