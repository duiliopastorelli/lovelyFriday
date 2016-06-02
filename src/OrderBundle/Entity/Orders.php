<?php

namespace OrderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Orders
 *
 * @ORM\Table(name="orders")
 * @ORM\Entity(repositoryClass="OrderBundle\Repository\OrdersRepository")
 */
class Orders
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
     * @ORM\Column(name="idManOrder", type="string", length=12, unique=true)
     */
    private $idManOrder;

    /**
     * @var string
     *
     * @ORM\Column(name="idOrder", type="string", length=12)
     */
    private $idOrder;

    /**
     * @var string
     *
     * @ORM\Column(name="userName", type="string", length=30, unique=true)
     */
    private $userName;

    /**
     * @var string
     *
     * @ORM\Column(name="plate", type="string", length=50)
     */
    private $plate;

    /**
     * @var string
     *
     * @ORM\Column(name="cookLevel", type="string", nullable=true)
     */
    private $cookLevel;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="string", length=150, nullable=true)
     */
    private $note;


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
     * Set idManOrder
     *
     * @param string $idManOrder
     *
     * @return Orders
     */
    public function setIdManOrder($idManOrder)
    {
        $this->idManOrder = $idManOrder;

        return $this;
    }

    /**
     * Get idManOrder
     *
     * @return string
     */
    public function getIdManOrder()
    {
        return $this->idManOrder;
    }

    /**
     * Set idOrder
     *
     * @param string $idOrder
     *
     * @return Orders
     */
    public function setIdOrder($idOrder)
    {
        $this->idOrder = $idOrder;

        return $this;
    }

    /**
     * Get idOrder
     *
     * @return string
     */
    public function getIdOrder()
    {
        return $this->idOrder;
    }

    /**
     * Set userName
     *
     * @param string $userName
     *
     * @return Orders
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get userName
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set plate
     *
     * @param string $plate
     *
     * @return Orders
     */
    public function setPlate($plate)
    {
        $this->plate = $plate;

        return $this;
    }

    /**
     * Get plate
     *
     * @return string
     */
    public function getPlate()
    {
        return $this->plate;
    }

    /**
     * Set cookLevel
     *
     * @param string $cookLevel
     *
     * @return Orders
     */
    public function setCookLevel($cookLevel)
    {
        $this->cookLevel = $cookLevel;

        return $this;
    }

    /**
     * Get cookLevel
     *
     * @return string
     */
    public function getCookLevel()
    {
        return $this->cookLevel;
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return Orders
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }
}
