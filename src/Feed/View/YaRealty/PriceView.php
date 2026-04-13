<?php


namespace App\Feed\View\YaRealty;


class PriceView
{
    const CURRENCY_RUR = "RUR";

    /**
     * @var int|null
     */
    protected $value;

    /**
     * @var string|null
     */
    protected $currency;

    /**
     * @return int|null
     */
    public function getValue(): ?int
    {
        return $this->value;
    }

    /**
     * @param int|null $value
     * @return PriceView
     */
    public function setValue(?int $value): PriceView
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @param string|null $currency
     * @return PriceView
     */
    public function setCurrency(?string $currency): PriceView
    {
        $this->currency = $currency;
        return $this;
    }

}