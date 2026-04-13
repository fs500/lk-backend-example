<?php


namespace App\Feed\View\YaRealty;


class AreaView
{
    const UNIT_DEFAULT = "кв. м";

    /**
     * @var float|int|null
     */
    protected $value;

    /**
     * @var string|null
     */
    protected $unit;

    /**
     * @return float|int|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param float|int|null $value
     * @return AreaView
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUnit(): ?string
    {
        return $this->unit;
    }

    /**
     * @param string|null $unit
     * @return AreaView
     */
    public function setUnit(?string $unit): AreaView
    {
        $this->unit = $unit;
        return $this;
    }
}