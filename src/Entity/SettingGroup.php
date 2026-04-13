<?php

namespace App\Entity;

use App\Repository\SettingGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SettingGroupRepository::class)
 */
class SettingGroup
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var ArrayCollection|Setting[]
     * @ORM\OneToMany(targetEntity="Setting", mappedBy="group", orphanRemoval=true, cascade={"persist","remove"})
     */
    private $settings;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $header;

    public function __construct()
    {
        $this->settings = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->header;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Setting[]|ArrayCollection
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * @param Setting $setting
     * @return $this
     */
    public function addSetting(Setting $setting){
        if(!$this->settings->contains($setting)){
            $this->settings->add($setting);
            $setting->setGroup($this);
        }

        return $this;
    }

    /**
     * @param Setting $setting
     * @return $this
     */
    public function removeSetting(Setting $setting){
        if($this->settings->contains($setting)){
            $this->settings->removeElement($setting);
            $setting->setGroup(null);
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return SettingGroup
     */
    public function setName(?string $name): SettingGroup
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHeader(): ?string
    {
        return $this->header;
    }

    /**
     * @param string|null $header
     * @return SettingGroup
     */
    public function setHeader(?string $header): SettingGroup
    {
        $this->header = $header;
        return $this;
    }
}
