<?php


namespace App\Validator;


use Symfony\Component\Validator\Constraint;
/**
 * @Annotation
 */
class PasswordConstraint extends Constraint
{
    public $message = "Пароль должен содержать не меньше 8 символов, с использованием 1 цифры, буквы и одного спец. символа";

    public function getTargets(){
        return self::PROPERTY_CONSTRAINT;
    }
}