<?php


namespace App\Form\Search;


use App\Entity\Flat;
use App\Entity\Floor;
use App\Entity\Form\Search\FlatSearch;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FlatSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', IntegerType::class, [
                'label' => false,
            ])
            ->add('floor', EntityType::class, [
                'label' => false,
                'class' => Floor::class,
                'multiple' => false,
                'placeholder' => '',
            ])
            ->add('rooms', ChoiceType::class, [
                'label' => false,
                'choices' => array_flip(Flat::getRoomsChoices()),
                'multiple' => false,
                'placeholder' => '',
            ])
            ->add('status', ChoiceType::class, [
                'label' => false,
                'choices' => array_flip(Flat::getStatusChoices()),
                'multiple' => false,
                'placeholder' => '',
            ])
            ->add('price', IntegerType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('priceFinish', IntegerType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('priceAction', IntegerType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('sortOrder', HiddenType::class)
            ->add('sort', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => FlatSearch::class,
                'method' => 'get',
                'csrf_protection' => false,
                'attr' => ['novalidate' => 'novalidate'],
                'allow_extra_fields' => true
            ])
        ;
    }

    public function getBlockPrefix()
    {
        return "";
    }
}