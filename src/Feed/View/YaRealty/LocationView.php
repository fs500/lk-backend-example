<?php


namespace App\Feed\View\YaRealty;


class LocationView
{
    /**
     * @var string|null
     */
    protected $country;

    /**
     * @var string|null
     */
    protected $region;

    /**
     * @var string|null
     */
    protected $district;

    /**
     * @var string|null
     */
    protected $localityName;

    /**
     * @var string|null
     */
    protected $address;

    /**
     * @var string|null
     */
    protected $direction;

    /**
     * @var string|null
     */
    protected $distance;

    /**
     * @var string|null
     */
    protected $latitude;

    /**
     * @var string|null
     */
    protected $longitude;

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     * @return LocationView
     */
    public function setCountry(?string $country): LocationView
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRegion(): ?string
    {
        return $this->region;
    }

    /**
     * @param string|null $region
     * @return LocationView
     */
    public function setRegion(?string $region): LocationView
    {
        $this->region = $region;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDistrict(): ?string
    {
        return $this->district;
    }

    /**
     * @param string|null $district
     * @return LocationView
     */
    public function setDistrict(?string $district): LocationView
    {
        $this->district = $district;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLocalityName(): ?string
    {
        return $this->localityName;
    }

    /**
     * @param string|null $localityName
     * @return LocationView
     */
    public function setLocalityName(?string $localityName): LocationView
    {
        $this->localityName = $localityName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     * @return LocationView
     */
    public function setAddress(?string $address): LocationView
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDirection(): ?string
    {
        return $this->direction;
    }

    /**
     * @param string|null $direction
     * @return LocationView
     */
    public function setDirection(?string $direction): LocationView
    {
        $this->direction = $direction;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDistance(): ?string
    {
        return $this->distance;
    }

    /**
     * @param string|null $distance
     * @return LocationView
     */
    public function setDistance(?string $distance): LocationView
    {
        $this->distance = $distance;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    /**
     * @param string|null $latitude
     * @return LocationView
     */
    public function setLatitude(?string $latitude): LocationView
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    /**
     * @param string|null $longitude
     * @return LocationView
     */
    public function setLongitude(?string $longitude): LocationView
    {
        $this->longitude = $longitude;
        return $this;
    }
}