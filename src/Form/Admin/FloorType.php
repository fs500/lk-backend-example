<?php

namespace App\Form\Admin;

use App\Entity\Floor;
use Eyetronic\AjaxUploaderBundle\Form\Type\AjaxFileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FloorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', null, [
                'label' => 'Номер',
            ])
            ->add('planFile', AjaxFileType::class, [
                'label' => 'Планировка',
                'by_reference' => false,
                'show_thumbnail' => true,
                'enable_delete' => true,
            ])
            ->add('miniPlanFile', AjaxFileType::class, [
                'label' => 'Планировка карточки',
                'by_reference' => false,
                'show_thumbnail' => true,
                'enable_delete' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Floor::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ]
        ]);
    }
}
