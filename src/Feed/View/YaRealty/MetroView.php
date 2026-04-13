<?php


namespace App\Feed\View\YaRealty;


class MetroView
{
    /**
     * @var string|null
     */
    protected $name;

    /**
     * @var string|null
     */
    protected $timeOnFoot;

    /**
     * @var string|null
     */
    protected $timeOnTransport;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return MetroView
     */
    public function setName(?string $name): MetroView
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTimeOnFoot(): ?string
    {
        return $this->timeOnFoot;
    }

    /**
     * @param string|null $timeOnFoot
     * @return MetroView
     */
    public function setTimeOnFoot(?string $timeOnFoot): MetroView
    {
        $this->timeOnFoot = $timeOnFoot;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTimeOnTransport(): ?string
    {
        return $this->timeOnTransport;
    }

    /**
     * @param string|null $timeOnTransport
     * @return MetroView
     */
    public function setTimeOnTransport(?string $timeOnTransport): MetroView
    {
        $this->timeOnTransport = $timeOnTransport;
        return $this;
    }
}