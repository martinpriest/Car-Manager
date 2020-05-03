<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CostHistory
 *
 * @ORM\Table(name="cost_history", indexes={@ORM\Index(name="idCostType", columns={"idCostType"}), @ORM\Index(name="idCar", columns={"idCar"})})
 * @ORM\Entity
 */
class CostHistory
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
     * @ORM\Column(name="idUser", type="integer", nullable=false)
     */
    private $iduser;

    /**
     * @var int
     *
     * @ORM\Column(name="idCar", type="integer", nullable=false)
     */
    private $idcar;

    /**
     * @var string
     *
     * @ORM\Column(name="factureImagePath", type="string", length=64, nullable=false)
     */
    private $factureimagepath;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float", precision=10, scale=0, nullable=false)
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", length=32, nullable=false)
     */
    private $currency;

    /**
     * @var float
     *
     * @ORM\Column(name="exchangeRate", type="float", precision=10, scale=0, nullable=false)
     */
    private $exchangerate;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=512, nullable=false)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $date = 'CURRENT_TIMESTAMP';

    /**
     * @var \CostTypes
     *
     * @ORM\ManyToOne(targetEntity="CostTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCostType", referencedColumnName="id")
     * })
     */
    private $idcosttype;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function setIduser(int $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }

    public function getIdcar(): ?int
    {
        return $this->idcar;
    }

    public function setIdcar(int $idcar): self
    {
        $this->idcar = $idcar;

        return $this;
    }

    public function getFactureimagepath(): ?string
    {
        return $this->factureimagepath;
    }

    public function setFactureimagepath(string $factureimagepath): self
    {
        $this->factureimagepath = $factureimagepath;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getExchangerate(): ?float
    {
        return $this->exchangerate;
    }

    public function setExchangerate(float $exchangerate): self
    {
        $this->exchangerate = $exchangerate;

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

    public function getIdcosttype(): ?CostTypes
    {
        return $this->idcosttype;
    }

    public function setIdcosttype(?CostTypes $idcosttype): self
    {
        $this->idcosttype = $idcosttype;

        return $this;
    }


}
