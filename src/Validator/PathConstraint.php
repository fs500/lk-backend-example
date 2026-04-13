<?php


namespace App\Validator;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class PathConstraint extends Constraint
{
    public $message = "Недопустимые символы. Для указания пути используйте символы латинского алфавита в нижнем регистре, цифры, символ подчеркивания или черточку.";

    public function getTargets()
    {
        return self::PROPERTY_CONSTRAINT;
    }
}