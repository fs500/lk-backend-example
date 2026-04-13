<?php


namespace App\Form\DataTransformer;


use App\Entity\Link;
use Symfony\Component\Form\DataTransformerInterface;

class PreventEmptyLinkTransformer implements DataTransformerInterface
{
    /**
     * @param mixed $id
     * @return mixed
     */
    public function transform($id)
    {
        return $id;
    }

    /**
     * @param mixed $link
     * @return mixed|null
     */
    public function reverseTransform($link)
    {
        assert($link instanceof Link);

        if ($link->getType() == null) {
            return null;
        }

        return $link;
    }
}