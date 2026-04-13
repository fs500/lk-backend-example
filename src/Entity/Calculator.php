<?php

namespace App\Entity;

use App\Repository\CalculatorRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CalculatorRepository::class)
 */
class Calculator
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $priceDefault;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $paymentMin;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $paymentMax;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $defaultPayment;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $yearsMin;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $yearsMax;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $defaultYears;

    /**
     * @var float|null
     * @ORM\Column(type="float", precision=5, scale=2, nullable=true)
     */
    private $rateMin;

    /**
     * @var float|null
     * @ORM\Column(type="float", precision=5, scale=2, nullable=true)
     */
    private $rateMax;

    /**
     * @var float|null
     * @ORM\Column(type="float", precision=5, scale=2, nullable=true)
     */
    private $rateDefault;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getPriceDefault(): ?int
    {
        return $this->priceDefault;
    }

    /**
     * @param int|null $priceDefault
     * @return Calculator
     */
    public function setPriceDefault(?int $priceDefault): Calculator
    {
        $this->priceDefault = $priceDefault;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPaymentMin(): ?int
    {
        return $this->paymentMin;
    }

    /**
     * @param int|null $paymentMin
     * @return Calculator
     */
    public function setPaymentMin(?int $paymentMin): Calculator
    {
        $this->paymentMin = $paymentMin;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPaymentMax(): ?int
    {
        return $this->paymentMax;
    }

    /**
     * @param int|null $paymentMax
     * @return Calculator
     */
    public function setPaymentMax(?int $paymentMax): Calculator
    {
        $this->paymentMax = $paymentMax;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getDefaultPayment(): ?int
    {
        return $this->defaultPayment;
    }

    /**
     * @param int|null $defaultPayment
     * @return Calculator
     */
    public function setDefaultPayment(?int $defaultPayment): Calculator
    {
        $this->defaultPayment = $defaultPayment;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getYearsMin(): ?int
    {
        return $this->yearsMin;
    }

    /**
     * @param int|null $yearsMin
     * @return Calculator
     */
    public function setYearsMin(?int $yearsMin): Calculator
    {
        $this->yearsMin = $yearsMin;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getYearsMax(): ?int
    {
        return $this->yearsMax;
    }

    /**
     * @param int|null $yearsMax
     * @return Calculator
     */
    public function setYearsMax(?int $yearsMax): Calculator
    {
        $this->yearsMax = $yearsMax;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getDefaultYears(): ?int
    {
        return $this->defaultYears;
    }

    /**
     * @param int|null $defaultYears
     * @return Calculator
     */
    public function setDefaultYears(?int $defaultYears): Calculator
    {
        $this->defaultYears = $defaultYears;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getRateMin(): ?float
    {
        return $this->rateMin;
    }

    /**
     * @param float|null $rateMin
     * @return Calculator
     */
    public function setRateMin(?float $rateMin): Calculator
    {
        $this->rateMin = $rateMin;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getRateMax(): ?float
    {
        return $this->rateMax;
    }

    /**
     * @param float|null $rateMax
     * @return Calculator
     */
    public function setRateMax(?float $rateMax): Calculator
    {
        $this->rateMax = $rateMax;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getRateDefault(): ?float
    {
        return $this->rateDefault;
    }

    /**
     * @param float|null $rateDefault
     * @return Calculator
     */
    public function setRateDefault(?float $rateDefault): Calculator
    {
        $this->rateDefault = $rateDefault;
        return $this;
    }

}
