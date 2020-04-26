<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CostHistory
 *
 * @ORM\Table(name="cost_history", indexes={@ORM\Index(name="idCar", columns={"idCar"}), @ORM\Index(name="idCostType", columns={"idCostType"})})
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


}
