<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RepairHistory
 *
 * @ORM\Table(name="repair_history", indexes={@ORM\Index(name="idFacture", columns={"idFacture"}), @ORM\Index(name="idCar", columns={"idCar"})})
 * @ORM\Entity
 */
class RepairHistory
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
     * @ORM\Column(name="description", type="integer", nullable=false)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $date = 'CURRENT_TIMESTAMP';

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
     * @var \CostHistory
     *
     * @ORM\ManyToOne(targetEntity="CostHistory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idFacture", referencedColumnName="id")
     * })
     */
    private $idfacture;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?int
    {
        return $this->description;
    }

    public function setDescription(int $description): self
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

    public function getIdfacture(): ?CostHistory
    {
        return $this->idfacture;
    }

    public function setIdfacture(?CostHistory $idfacture): self
    {
        $this->idfacture = $idfacture;

        return $this;
    }


}
