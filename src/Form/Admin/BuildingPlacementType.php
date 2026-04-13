<?php


namespace App\Form\Admin;


use App\Entity\BuildingPlacement;
use Eyetronic\AjaxUploaderBundle\Form\Type\AjaxFileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BuildingPlacementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('iconFile', AjaxFileType::class, [
                'label' => 'Значок',
                'by_reference' => false,
                'show_thumbnail' => true,
                'enable_delete' => true,
            ])
            ->add('header', null, [
                'label' => 'Заголовок'
            ])
            ->add('description', null, [
                'label' => 'Краткое описание'
            ])
            ->add('sort', HiddenType::class,[
                'attr' => [
                    'class' => 'sort-field'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BuildingPlacement::class
        ]);
    }
}