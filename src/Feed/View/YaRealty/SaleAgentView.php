<?php


namespace App\Feed\View\YaRealty;


class SaleAgentView
{
    const CATEGORY_AGENCY = "агентство";

    const CATEGORY_DEVELOPER = "застройщик";

    /**
     * @var string|null
     */
    protected $name;

    /**
     * @var string|null
     */
    protected $phone;

    /**
     * @var string|null
     */
    protected $category;

    /**
     * @var string|null
     */
    protected $organization;

    /**
     * @var string|null
     */
    protected $url;

    /**
     * @var string|null
     */
    protected $email;

    /**
     * @var string|null
     */
    protected $photo;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return SaleAgentView
     */
    public function setName(?string $name): SaleAgentView
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     * @return SaleAgentView
     */
    public function setPhone(?string $phone): SaleAgentView
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @param string|null $category
     * @return SaleAgentView
     */
    public function setCategory(?string $category): SaleAgentView
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOrganization(): ?string
    {
        return $this->organization;
    }

    /**
     * @param string|null $organization
     * @return SaleAgentView
     */
    public function setOrganization(?string $organization): SaleAgentView
    {
        $this->organization = $organization;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     * @return SaleAgentView
     */
    public function setUrl(?string $url): SaleAgentView
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return SaleAgentView
     */
    public function setEmail(?string $email): SaleAgentView
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    /**
     * @param string|null $photo
     * @return SaleAgentView
     */
    public function setPhoto(?string $photo): SaleAgentView
    {
        $this->photo = $photo;
        return $this;
    }
}