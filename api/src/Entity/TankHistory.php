<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TankHistory
 *
 * @ORM\Table(name="tank_history", indexes={@ORM\Index(name="idCar", columns={"idCar"}), @ORM\Index(name="idPetrolType", columns={"idPetrolType"}), @ORM\Index(name="idFacture", columns={"idFacture"})})
 * @ORM\Entity
 */
class TankHistory
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
     * @var float
     *
     * @ORM\Column(name="amount", type="float", precision=10, scale=0, nullable=false)
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="petrolStation", type="string", length=64, nullable=false)
     */
    private $petrolstation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $date = 'CURRENT_TIMESTAMP';

    /**
     * @var \PetrolTypes
     *
     * @ORM\ManyToOne(targetEntity="PetrolTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idPetrolType", referencedColumnName="id")
     * })
     */
    private $idpetroltype;

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


}
