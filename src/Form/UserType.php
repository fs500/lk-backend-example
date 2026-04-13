<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, [
                'label' => 'Имя пользователя'
            ])
            ->add('roles', ChoiceType::class,[
                'label' => 'Роли',
                'choices' => array_flip(User::getRolesChoices()),
                'multiple' => true,
            ])
            ->add('newPassword', PasswordType::class, [
                'label' => 'Пароль',
                'required' => false
            ])
            ->add('confirmPassword', PasswordType::class, [
                'label' => 'Подтверждение пароля',
                'required' => false
            ])
            ->add('email', null, [
                'label' => 'Email'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ]
        ]);
    }
}
