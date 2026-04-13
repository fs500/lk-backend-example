<?php


namespace App\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PasswordConstraintValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if(!empty($value)){
            if(!preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&_\-])[A-Za-z\d@$!%*#?&_\-]{8,}$/", $value)){
                $this->context->buildViolation($constraint->message)->atPath('newPassword')->addViolation();
            }
        }
    }
}