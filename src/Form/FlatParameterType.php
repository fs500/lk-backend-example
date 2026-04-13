<?php


namespace App\Form;


use App\Entity\Form\FlatParameter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FlatParameterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('priceMin', null, [
                'required' => false
            ])
            ->add('priceMax', null, [
                'required' => false
            ])
            ->add('areaMin', null, [
                'required' => false
            ])
            ->add('areaMax', null, [
                'required' => false
            ])
            ->add('floorMin', null, [
                'required' => false
            ])
            ->add('floorMax', null, [
                'required' => false
            ])
            ->add('rooms', ChoiceType::class, [
                'required' => false,
                'choices' => array_flip(FlatParameter::getRoomsChoices()),
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('statuses', ChoiceType::class, [
                'required' => false,
                'choices' => array_flip(FlatParameter::getStatusesChoices()),
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('sortField', ChoiceType::class, [
                'required' => false,
                'choices' => array_flip(FlatParameter::getSortFieldChoices()),
            ])
            ->add('sortOrder', ChoiceType::class, [
                'required' => false,
                'choices' => array_flip(FlatParameter::getSortOrderChoices()),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FlatParameter::class,
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}