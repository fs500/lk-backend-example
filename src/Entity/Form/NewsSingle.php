<?php


namespace App\Entity\Form;


class NewsSingle
{

    /**
     * @var int|null
     */
    private $after;

    /**
     * @var int|null
     */
    private $before;

    /**
     * @return int|null
     */
    public function getAfter(): ?int
    {
        return $this->after;
    }

    /**
     * @param int|null $after
     * @return NewsSingle
     */
    public function setAfter(?int $after): NewsSingle
    {
        $this->after = $after;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getBefore(): ?int
    {
        return $this->before;
    }

    /**
     * @param int|null $before
     * @return NewsSingle
     */
    public function setBefore(?int $before): NewsSingle
    {
        $this->before = $before;
        return $this;
    }
}