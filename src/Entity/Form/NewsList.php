<?php


namespace App\Entity\Form;


class NewsList
{
    /**
     * @var int|null
     */
    private $offset;

    /**
     * @var int|null
     */
    private $limit;

    /**
     * @return int|null
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }

    /**
     * @param int|null $offset
     * @return NewsList
     */
    public function setOffset(?int $offset): NewsList
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * @param int|null $limit
     * @return NewsList
     */
    public function setLimit(?int $limit): NewsList
    {
        $this->limit = $limit;
        return $this;
    }
}