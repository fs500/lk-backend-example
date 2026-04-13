<?php


namespace App\Form\Admin;


use App\Entity\Setting;
use Eyetronic\AjaxUploaderBundle\Form\Type\AjaxFileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('value', null, [
                'label' => false
            ])
            ->add('uploadedFile', AjaxFileType::class,[
                'label' => false,
                'required' => false,
                'enable_delete' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Setting::class,
            'error_bubbling' => false,
            'label' => false,
            'csrf_protection' => false,
            'attr' => [
                'novalidate' => 'novalidate'
            ],
        ]);
    }
}