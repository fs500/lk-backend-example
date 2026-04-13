<?php


namespace App\Form\Admin;


use App\Entity\InfrastructureItem;
use Eyetronic\AjaxUploaderBundle\Form\Type\AjaxFileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InfrastructureItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => 'Название объекта',
            ])
            ->add('description', TextType::class, [
                'label' => 'Краткое описание',
                'required' => false
            ])
            ->add('address', TextType::class, [
                'label' => 'Адрес',
                'required' => false
            ])
            ->add('latitude', NumberType::class, [
                'label' => 'Широта (на карте)',
                'scale' => 6
            ])
            ->add('longitude', NumberType::class, [
                'label' => 'Долгота (на карте)',
                'scale' => 6
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InfrastructureItem::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ]
        ]);
    }
}