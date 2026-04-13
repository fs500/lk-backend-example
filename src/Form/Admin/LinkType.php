<?php


namespace App\Form\Admin;


use App\Entity\Link;
use App\Entity\Page;
use App\Form\DataTransformer\PreventEmptyLinkTransformer;
use Eyetronic\AjaxUploaderBundle\Form\Type\AjaxFileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LinkType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class,[
                'choices' => array_flip(Link::typeChoices()),
                'empty_data' => "",
                'label' => false,
                'placeholder' => 'Выберите тип ссылки',
                'attr' => [
                    'class' => 'link-type'
                ],
            ])
            ->add('popup',CheckboxType::class,[
                'required' => false,
                'label' => false,
            ])
            ->add('header', TextType::class,[
                'empty_data' => null,
                'attr' => [
                    'placeholder' => 'Текст ссылки',
                ],
                'label' => false,
            ])
            ->add('page',ChoiceType::class,[
                'choices' => array_flip(Page::getTypeChoices()),
                'empty_data' => null,
                'label' => false,
                'placeholder' => 'Выберите страницу',
                'attr' => [
                    'class' => 'link-page'
                ],
            ])
            ->add('url', TextType::class,[
                'label' => false,
                'attr' => [
                    'class' => 'link-url',
                    'placeholder' => 'URL',
                ],
            ])
            ->add('uploadedFile', AjaxFileType::class)
            ->addModelTransformer(new PreventEmptyLinkTransformer())
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Link::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ],
        ]);
    }
}