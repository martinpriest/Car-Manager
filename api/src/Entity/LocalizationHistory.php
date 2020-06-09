<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LocalizationHistory
 *
 * @ORM\Table(name="localization_history", indexes={@ORM\Index(name="idCar", columns={"idCar"}), @ORM\Index(name="idStartAddress", columns={"idStartAddress"}), @ORM\Index(name="idUser", columns={"idUser"}), @ORM\Index(name="idEndAddress", columns={"idEndAddress"})})
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
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUser", referencedColumnName="id")
     * })
     */
    private $iduser;

    /**
     * @var \Car
     *
     * @ORM\ManyToOne(targetEntity="Car")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCar", referencedColumnName="id")
     * })
     */
    private $idcar;

    /**
     * @var \Address
     *
     * @ORM\ManyToOne(targetEntity="Address")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idStartAddress", referencedColumnName="id")
     * })
     */
    private $idstartaddress;

    /**
     * @var \Address
     *
     * @ORM\ManyToOne(targetEntity="Address")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEndAddress", referencedColumnName="id")
     * })
     */
    private $idendaddress;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIduser(): ?User
    {
        return $this->iduser;
    }

    public function setIduser(?User $iduser): self
    {
        $this->iduser = $iduser;

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

    public function getIdstartaddress(): ?Address
    {
        return $this->idstartaddress;
    }

    public function setIdstartaddress(?Address $idstartaddress): self
    {
        $this->idstartaddress = $idstartaddress;

        return $this;
    }

    public function getIdendaddress(): ?Address
    {
        return $this->idendaddress;
    }

    public function setIdendaddress(?Address $idendaddress): self
    {
        $this->idendaddress = $idendaddress;

        return $this;
    }


}
