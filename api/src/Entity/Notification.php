<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 *
 * @ORM\Table(name="notification", indexes={@ORM\Index(name="idNotificationType", columns={"idNotificationType"}), @ORM\Index(name="idCar", columns={"idCar"}), @ORM\Index(name="idUser", columns={"idUser"})})
 * @ORM\Entity
 */
class Notification
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
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1024, nullable=false)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="notificationDate", type="date", nullable=false)
     */
    private $notificationdate;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @var \NotificationTypes
     *
     * @ORM\ManyToOne(targetEntity="NotificationTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idNotificationType", referencedColumnName="id")
     * })
     */
    private $idnotificationtype;

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
