<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Car
 *
 * @ORM\Table(name="car", indexes={@ORM\Index(name="idUser", columns={"idUser"}), @ORM\Index(name="idCarGroup", columns={"idCarGroup"}), @ORM\Index(name="idAvatarFile", columns={"idAvatarFile"})})
 * @ORM\Entity
 */
class Car
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
     * @var bool|null
     *
     * @ORM\Column(name="isPublic", type="boolean", nullable=true)
     */
    private $ispublic = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=64, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="mark", type="string", length=128, nullable=false)
     */
    private $mark;

    /**
     * @var string
     *
     * @ORM\Column(name="model", type="string", length=128, nullable=false)
     */
    private $model;

    /**
     * @var int
     *
     * @ORM\Column(name="year", type="smallint", nullable=false, options={"default"="2020"})
     */
    private $year = '2020';

    /**
     * @var string
     *
     * @ORM\Column(name="hexColor", type="string", length=6, nullable=false)
     */
    private $hexcolor;

    /**
     * @var int
     *
     * @ORM\Column(name="engineMileage", type="integer", nullable=false)
     */
    private $enginemileage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $creationdate = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="purchaseDate", type="date", nullable=true)
     */
    private $purchasedate;

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
     * @var \CarGroup
     *
     * @ORM\ManyToOne(targetEntity="CarGroup")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCarGroup", referencedColumnName="id")
     * })
     */
    private $idcargroup;

    /**
     * @var \File
     *
     * @ORM\ManyToOne(targetEntity="File")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idAvatarFile", referencedColumnName="id")
     * })
     */
    private $idavatarfile;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIspublic(): ?bool
    {
        return $this->ispublic;
    }

    public function setIspublic(?bool $ispublic): self
    {
        $this->ispublic = $ispublic;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMark(): ?string
    {
        return $this->mark;
    }

    public function setMark(string $mark): self
    {
        $this->mark = $mark;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getHexcolor(): ?string
    {
        return $this->hexcolor;
    }

    public function setHexcolor(string $hexcolor): self
    {
        $this->hexcolor = $hexcolor;

        return $this;
    }

    public function getEnginemileage(): ?int
    {
        return $this->enginemileage;
    }

    public function setEnginemileage(int $enginemileage): self
    {
        $this->enginemileage = $enginemileage;

        return $this;
    }

    public function getCreationdate(): ?\DateTimeInterface
    {
        return $this->creationdate;
    }

    public function setCreationdate(\DateTimeInterface $creationdate): self
    {
        $this->creationdate = $creationdate;

        return $this;
    }

    public function getPurchasedate(): ?\DateTimeInterface
    {
        return $this->purchasedate;
    }

    public function setPurchasedate(?\DateTimeInterface $purchasedate): self
    {
        $this->purchasedate = $purchasedate;

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

    public function getIdcargroup(): ?CarGroup
    {
        return $this->idcargroup;
    }

    public function setIdcargroup(?CarGroup $idcargroup): self
    {
        $this->idcargroup = $idcargroup;

        return $this;
    }

    public function getIdavatarfile(): ?File
    {
        return $this->idavatarfile;
    }

    public function setIdavatarfile(?File $idavatarfile): self
    {
        $this->idavatarfile = $idavatarfile;

        return $this;
    }


}
