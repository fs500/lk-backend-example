<?php


namespace App\Form\Admin;


use App\Entity\PageSlide;
use App\Form\Admin\LinkType;
use Eyetronic\AjaxUploaderBundle\Form\Type\AjaxFileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageSlideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', AjaxFileType::class, [
                'label' => 'Изображение',
                'by_reference' => false,
                'show_thumbnail' => true,
                'enable_delete' => true,
            ])
            ->add('header', null, [
                'label' => 'Заголовок'
            ])
            ->add('description', null, [
                'label' => 'Текст'
            ])
            ->add('link', LinkType::class, [
                'label' => 'Ссылка на выборщик',
            ])
            ->add('liveBroadcast', LinkType::class, [
                'label' => 'Ссылка на трансляцию',
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
            'data_class' => PageSlide::class
        ]);
    }
}