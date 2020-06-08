<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CarGroup
 *
 * @ORM\Table(name="car_group")
 * @ORM\Entity
 */
class CarGroup
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
     * @var int|null
     *
     * @ORM\Column(name="idUser", type="integer", nullable=true)
     */
    private $iduser;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=32, nullable=false, options={"default"="Default car group"})
     */
    private $name = 'Default car group';

    /**
     * @var int
     *
     * @ORM\Column(name="menuPosition", type="integer", nullable=false, options={"default"="1"})
     */
    private $menuposition = '1';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $creationdate = 'CURRENT_TIMESTAMP';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function setIduser(?int $iduser): self
    {
        $this->iduser = $iduser;

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

    public function getMenuposition(): ?int
    {
        return $this->menuposition;
    }

    public function setMenuposition(int $menuposition): self
    {
        $this->menuposition = $menuposition;

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


}
