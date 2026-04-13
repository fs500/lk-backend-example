<?php


namespace App\Validator;


use App\Entity\BuildingProgress;
use App\Repository\BuildingProgressRepository;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ValidatorException;

class BuildingProgressConstraintValidator extends ConstraintValidator
{
    /**
     * @var BuildingProgressRepository
     */
    private $repository;

    public function __construct(BuildingProgressRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param BuildingProgress $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if(empty($value->getDate())){
            throw new ValidatorException('Date is not set');
        }
        if($this->repository->countDuplicatesByDate($value) > 0){
            $this->context->buildViolation("Альбом для этого месяца уже существует, добавляйте фотографии для этого месяца в уже существующий альбом.")
                ->atPath('date')
                ->addViolation();
        }
    }
}