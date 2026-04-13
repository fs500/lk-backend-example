<?php


namespace App\Validator;


use App\Repository\NewsRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PathConstraintValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {


        if(preg_match('/[^-0-9a-z_]/', $value)){
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}