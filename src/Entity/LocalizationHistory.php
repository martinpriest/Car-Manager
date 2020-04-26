<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LocalizationHistory
 *
 * @ORM\Table(name="localization_history", indexes={@ORM\Index(name="idCar", columns={"idCar"})})
 * @ORM\Entity
 */
class LocalizationHistory
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="startLocalizationLink", type="string", length=1024, nullable=false)
     */
    private $startlocalizationlink;

    /**
     * @var string
     *
     * @ORM\Column(name="endLocalizationLink", type="string", length=1024, nullable=false)
     */
    private $endlocalizationlink;

    /**
     * @var string
     *
     * @ORM\Column(name="startLocalizationName", type="string", length=64, nullable=false)
     */
    private $startlocalizationname;

    /**
     * @var string
     *
     * @ORM\Column(name="endLocalizationName", type="string", length=64, nullable=false)
     */
    private $endlocalizationname;

    /**
     * @var int
     *
     * @ORM\Column(name="distance", type="integer", nullable=false)
     */
    private $distance;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=128, nullable=false)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var \Car
     *
     * @ORM\ManyToOne(targetEntity="Car")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCar", referencedColumnName="id")
     * })
     */
    private $idcar;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartlocalizationlink(): ?string
    {
        return $this->startlocalizationlink;
    }

    public function setStartlocalizationlink(string $startlocalizationlink): self
    {
        $this->startlocalizationlink = $startlocalizationlink;

        return $this;
    }

    public function getEndlocalizationlink(): ?string
    {
        return $this->endlocalizationlink;
    }

    public function setEndlocalizationlink(string $endlocalizationlink): self
    {
        $this->endlocalizationlink = $endlocalizationlink;

        return $this;
    }

    public function getStartlocalizationname(): ?string
    {
        return $this->startlocalizationname;
    }

    public function setStartlocalizationname(string $startlocalizationname): self
    {
        $this->startlocalizationname = $startlocalizationname;

        return $this;
    }

    public function getEndlocalizationname(): ?string
    {
        return $this->endlocalizationname;
    }

    public function setEndlocalizationname(string $endlocalizationname): self
    {
        $this->endlocalizationname = $endlocalizationname;

        return $this;
    }

    public function getDistance(): ?int
    {
        return $this->distance;
    }

    public function setDistance(int $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getIdcar(): ?Car
    {
        return $this->idcar;
    }

    public function setIdcar(?Car $idcar): self
    {
        $this->idcar = $idcar;

        return $this;
    }


}
