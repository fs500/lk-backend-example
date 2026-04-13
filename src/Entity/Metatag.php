<?php

namespace App\Entity;

use Eyetronic\SymfonyMetatagBundle\Entity\Metatag as BaseMetatag;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MetatagRepository;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MetatagRepository::class)
 */
class Metatag extends BaseMetatag
{

}