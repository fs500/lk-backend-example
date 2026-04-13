<?php

namespace App\Form\Admin;

use App\Entity\YandexYmlSet;
use App\Entity\YandexYmlShop;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class YandexYmlSetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('shop', EntityType::class, [
                'label' => 'Фид',
                'class' => YandexYmlShop::class,
                'required' => true
            ])
            ->add('name', TextType::class, [
                'label' => 'Название',
                'required' => true
            ])
            ->add('url', TextType::class, [
                'label' => 'Url',
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => YandexYmlSet::class,
        ]);
    }
}
