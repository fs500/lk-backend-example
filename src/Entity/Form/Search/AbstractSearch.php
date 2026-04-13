<?php


namespace App\Entity\Form\Search;


abstract class AbstractSearch
{
    const SORT_ORDER_ASC = "asc";
    const SORT_ORDER_DESC = "desc";

    /**
     * @var string|null
     */
    protected $sort;

    /**
     * @var string|null
     */
    protected $sortOrder;

    /**
     * @return string|null
     */
    public function getSort(): ?string
    {
        return $this->sort;
    }

    /**
     * @param string|null $sort
     * @return AbstractSearch
     */
    public function setSort(?string $sort): AbstractSearch
    {
        $this->sort = $sort;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSortOrder(): ?string
    {
        return $this->sortOrder;
    }

    /**
     * @param string|null $sortOrder
     * @return AbstractSearch
     */
    public function setSortOrder(?string $sortOrder): AbstractSearch
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }
}