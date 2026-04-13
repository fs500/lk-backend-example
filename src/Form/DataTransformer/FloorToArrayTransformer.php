<?php


namespace App\Form\DataTransformer;


use App\Entity\Floor;
use App\Repository\FloorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class FloorToArrayTransformer implements DataTransformerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param array $values
     * @return Floor[]
     */
    public function transform($values)
    {
        $result = [];
        if(!is_null($values)){
            /** @var FloorRepository $repository */
            $repository = $this->em->getRepository(Floor::class);
            $result = $repository->findBy(['number' => $values],['number' => 'ASC']);
        }
        return $result;
    }

    /**
     * @param Floor[] $values
     * @return array
     */
    public function reverseTransform($values)
    {
        $result = [];
        if(!is_null($values)){
            foreach ($values as $value){
                $result[] = $value->getNumber();
            }
        }

        return $result;
    }
}