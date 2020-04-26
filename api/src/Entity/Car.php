<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Car
 *
 * @ORM\Table(name="car", indexes={@ORM\Index(name="idUser", columns={"idUser"})})
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
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=6, nullable=false)
     */
    private $color;

    /**
     * @var int
     *
     * @ORM\Column(name="engineMileage", type="integer", nullable=false)
     */
    private $enginemileage;

    /**
     * @var string
     *
     * @ORM\Column(name="imgPath", type="string", length=64, nullable=false)
     */
    private $imgpath;

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


}
