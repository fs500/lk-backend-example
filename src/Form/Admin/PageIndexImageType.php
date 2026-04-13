<?php


namespace App\Form\Admin;


use App\Entity\PageImage;
use Eyetronic\AjaxUploaderBundle\Form\Type\AjaxFileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageIndexImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('header', null, [
                'label' => 'Заголовок'
            ])
            ->add('text', null, [
                'label' => 'Текст'
            ])
            ->add('imageFile', AjaxFileType::class, [
                'label' => 'Изображение',
                'by_reference' => false,
                'show_thumbnail' => true,
                'enable_delete' => true,
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
            'data_class' => PageImage::class
        ]);
    }
}