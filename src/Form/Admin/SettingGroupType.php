<?php


namespace App\Form\Admin;


use App\Entity\SettingGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('settings', CollectionType::class, [
            'by_reference' => false,
            'error_bubbling' => false,
            'allow_add' => false,
            'allow_delete' => false,
            'entry_type' => SettingType::class,
            'row_attr' => [
                'class' => 'setting_form'
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SettingGroup::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ],
        ]);
    }
}