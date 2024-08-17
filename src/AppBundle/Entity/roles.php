<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\empleados;

/**
 * roles
 *
 * @ORM\Table(name="roles")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\rolesRepository")
 */
class roles
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\ManyToMany(targetEntity="empleados", mappedBy="roles")
     */
    private $empleados;

    public function __construct()
    {
        $this->empleados = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return roles
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    public function getEmpleados(): ArrayCollection
    {
        return $this->empleados;
    }

    public function addEmpleado(empleados $empleado): self
    {
        if (!$this->empleados->contains($empleado)) {
            $this->empleados[] = $empleado;
            $empleado->addRole($this);
        }

        return $this;
    }

    public function removeEmpleado(empleados $empleado): self
    {
        if ($this->empleados->contains($empleado)) {
            $this->empleados->removeElement($empleado);
            $empleado->removeRole($this);
        }

        return $this;
    }
}

