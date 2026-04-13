<?php


namespace App\Form\Admin;


use App\Entity\PageHowTo;
use Eyetronic\AjaxUploaderBundle\Form\Type\AjaxFileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageHowToType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('iconFile', AjaxFileType::class, [
                'label' => 'Иконка',
                'by_reference' => false,
                'show_thumbnail' => true,
                'enable_delete' => true,
            ])
            ->add('header', TextType::class, [
                'label' => 'Заголовок',
                'required' => false,
            ])
            ->add('text', TextType::class, [
                'label' => 'Текст',
                'required' => false,
            ])
            ->add('text2', TextType::class, [
                'label' => 'Примечание',
                'required' => false,
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
            'data_class' => PageHowTo::class
        ]);
    }
}