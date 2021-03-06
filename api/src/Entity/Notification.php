<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 *
 * @ORM\Table(name="notification", indexes={@ORM\Index(name="idCar", columns={"idCar"}), @ORM\Index(name="idNotificationType", columns={"idNotificationType"}), @ORM\Index(name="idUser", columns={"idUser"})})
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
     * @var \NotificationTypes
     *
     * @ORM\ManyToOne(targetEntity="NotificationTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idNotificationType", referencedColumnName="id")
     * })
     */
    private $idnotificationtype;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNotificationdate(): ?\DateTimeInterface
    {
        return $this->notificationdate;
    }

    public function setNotificationdate(\DateTimeInterface $notificationdate): self
    {
        $this->notificationdate = $notificationdate;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

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

    public function getIdnotificationtype(): ?NotificationTypes
    {
        return $this->idnotificationtype;
    }

    public function setIdnotificationtype(?NotificationTypes $idnotificationtype): self
    {
        $this->idnotificationtype = $idnotificationtype;

        return $this;
    }


}
