<?php


namespace App\Validator;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class BuildingProgressConstraint extends Constraint
{
    public $message = "";

    public function getTargets(){
        return self::CLASS_CONSTRAINT;
    }
}