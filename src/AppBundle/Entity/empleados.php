<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\areas;

/**
 * empleados
 *
 * @ORM\Table(name="empleados")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\empleadosRepository")
 */
class empleados
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
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="sexo", type="string", length=1)
     */
    private $sexo;

    /**
     * @var int
     *
     * @ORM\Column(name="boletin", type="integer")
     */
    private $boletin;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity="areas")
     * @ORM\JoinColumn(name="area_id", referencedColumnName="id", nullable=false)
     */
    private $area;

    /**
     * @ORM\ManyToMany(targetEntity="roles", inversedBy="empleados")
     * @ORM\JoinTable(name="empleado_rol",
     *      joinColumns={@ORM\JoinColumn(name="empleado_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="rol_id", referencedColumnName="id")}
     * )
     */
    private $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
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
     * @return empleados
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

    /**
     * Set email
     *
     * @param string $email
     *
     * @return empleados
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set sexo
     *
     * @param string $sexo
     *
     * @return empleados
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get sexo
     *
     * @return string
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Set boletin
     *
     * @param integer $boletin
     *
     * @return empleados
     */
    public function setBoletin($boletin)
    {
        $this->boletin = $boletin;

        return $this;
    }

    /**
     * Get boletin
     *
     * @return int
     */
    public function getBoletin()
    {
        return $this->boletin;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return empleados
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Get area.
     *
     * @return Area
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Set area.
     *
     * @param Area $area
     *
     * @return Empleado
     */
    public function setArea(areas $area)
    {
        $this->area = $area;

        return $this;
    }

    public function getRoles(): ArrayCollection
    {
        return $this->roles;
    }

    public function addRole(roles $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    public function removeRole(roles $role): self
    {
        $this->roles->removeElement($role);

        return $this;
    }
}

