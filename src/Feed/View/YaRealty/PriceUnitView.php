<?php


namespace App\Feed\View\YaRealty;


class PriceUnitView extends PriceView
{
    const UNIT_DEFAULT = "кв. м";

    /**
     * @var string|null
     */
    protected $unit;

    /**
     * @return string|null
     */
    public function getUnit(): ?string
    {
        return $this->unit;
    }

    /**
     * @param string|null $unit
     * @return PriceUnitView
     */
    public function setUnit(?string $unit): PriceUnitView
    {
        $this->unit = $unit;
        return $this;
    }
}