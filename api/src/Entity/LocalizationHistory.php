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


}
