<?php

namespace App\Form\Admin;

use App\Entity\FlatPrice;
use App\Entity\Floor;
use App\Form\DataTransformer\FloorToArrayTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FlatPriceType extends AbstractType
{
    /**
     * @var FloorToArrayTransformer
     */
    protected $floorTransformer;

    public function __construct(FloorToArrayTransformer $floorTransformer)
    {
        $this->floorTransformer = $floorTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('floors', EntityType::class, [
                'label' => 'Этажи',
                'class' => Floor::class,
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('rooms', ChoiceType::class, [
                'label' => 'Комнатность',
                'choices' => array_flip(FlatPrice::getRoomsChoices()),
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('price', null, [
                'label' => 'Цена за кв. м.',
            ])
        ;
        $builder
            ->get('floors')
            ->addModelTransformer($this->floorTransformer)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FlatPrice::class,
        ]);
    }
}
