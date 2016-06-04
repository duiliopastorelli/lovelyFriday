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
     * @ORM\Column(name="idManOrder", type="string", length=12)
     */
    private $idManOrder;

    /**
     * @var string
     *
     * @ORM\Column(name="idOrder", type="string", length=12)
     */
    private $idOrder;

    /**
     * @var date
     *
     * @ORM\Column(name="creationDate", type="date", nullable=true)
     */
    private $creationDate;

    /**
     * @var string
     *
     * @ORM\Column(name="userName", type="string", length=30, nullable=true)
     */
    private $userName;

    /**
     * @var string
     *
     * @ORM\Column(name="plate1", type="string", length=50, nullable=true)
     */
    private $plate1;

    /**
     * @var string
     *
     * @ORM\Column(name="cookLevel1", type="string", length=10, nullable=true)
     */
    private $cookLevel1;

    /**
     * @var string
     *
     * @ORM\Column(name="note1", type="string", length=150, nullable=true)
     */
    private $note1;

    /**
     * @var string
     *
     * @ORM\Column(name="plate2", type="string", length=50, nullable=true)
     */
    private $plate2;

    /**
     * @var string
     *
     * @ORM\Column(name="cookLevel2", type="string", length=10, nullable=true)
     */
    private $cookLevel2;

    /**
     * @var string
     *
     * @ORM\Column(name="note2", type="string", length=150, nullable=true)
     */
    private $note2;

    /**
     * @var string
     *
     * @ORM\Column(name="plate3", type="string", length=50, nullable=true)
     */
    private $plate3;

    /**
     * @var string
     *
     * @ORM\Column(name="cookLevel3", type="string", length=10, nullable=true)
     */
    private $cookLevel3;

    /**
     * @var string
     *
     * @ORM\Column(name="note3", type="string", length=150, nullable=true)
     */
    private $note3;

    /**
     * @var string
     *
     * @ORM\Column(name="plate4", type="string", length=50, nullable=true)
     */
    private $plate4;

    /**
     * @var string
     *
     * @ORM\Column(name="cookLevel4", type="string", length=10, nullable=true)
     */
    private $cookLevel4;

    /**
     * @var string
     *
     * @ORM\Column(name="note4", type="string", length=150, nullable=true)
     */
    private $note4;

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

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Orders
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set plate1
     *
     * @param string $plate1
     *
     * @return Orders
     */
    public function setPlate1($plate1)
    {
        $this->plate1 = $plate1;

        return $this;
    }

    /**
     * Get plate1
     *
     * @return string
     */
    public function getPlate1()
    {
        return $this->plate1;
    }

    /**
     * Set cookLevel1
     *
     * @param string $cookLevel1
     *
     * @return Orders
     */
    public function setCookLevel1($cookLevel1)
    {
        $this->cookLevel1 = $cookLevel1;

        return $this;
    }

    /**
     * Get cookLevel1
     *
     * @return string
     */
    public function getCookLevel1()
    {
        return $this->cookLevel1;
    }

    /**
     * Set note1
     *
     * @param string $note1
     *
     * @return Orders
     */
    public function setNote1($note1)
    {
        $this->note1 = $note1;

        return $this;
    }

    /**
     * Get note1
     *
     * @return string
     */
    public function getNote1()
    {
        return $this->note1;
    }

    /**
     * Set plate2
     *
     * @param string $plate2
     *
     * @return Orders
     */
    public function setPlate2($plate2)
    {
        $this->plate2 = $plate2;

        return $this;
    }

    /**
     * Get plate2
     *
     * @return string
     */
    public function getPlate2()
    {
        return $this->plate2;
    }

    /**
     * Set cookLevel2
     *
     * @param string $cookLevel2
     *
     * @return Orders
     */
    public function setCookLevel2($cookLevel2)
    {
        $this->cookLevel2 = $cookLevel2;

        return $this;
    }

    /**
     * Get cookLevel2
     *
     * @return string
     */
    public function getCookLevel2()
    {
        return $this->cookLevel2;
    }

    /**
     * Set note2
     *
     * @param string $note2
     *
     * @return Orders
     */
    public function setNote2($note2)
    {
        $this->note2 = $note2;

        return $this;
    }

    /**
     * Get note2
     *
     * @return string
     */
    public function getNote2()
    {
        return $this->note2;
    }

    /**
     * Set plate3
     *
     * @param string $plate3
     *
     * @return Orders
     */
    public function setPlate3($plate3)
    {
        $this->plate3 = $plate3;

        return $this;
    }

    /**
     * Get plate3
     *
     * @return string
     */
    public function getPlate3()
    {
        return $this->plate3;
    }

    /**
     * Set cookLevel3
     *
     * @param string $cookLevel3
     *
     * @return Orders
     */
    public function setCookLevel3($cookLevel3)
    {
        $this->cookLevel3 = $cookLevel3;

        return $this;
    }

    /**
     * Get cookLevel3
     *
     * @return string
     */
    public function getCookLevel3()
    {
        return $this->cookLevel3;
    }

    /**
     * Set note3
     *
     * @param string $note3
     *
     * @return Orders
     */
    public function setNote3($note3)
    {
        $this->note3 = $note3;

        return $this;
    }

    /**
     * Get note3
     *
     * @return string
     */
    public function getNote3()
    {
        return $this->note3;
    }

    /**
     * Set plate4
     *
     * @param string $plate4
     *
     * @return Orders
     */
    public function setPlate4($plate4)
    {
        $this->plate4 = $plate4;

        return $this;
    }

    /**
     * Get plate4
     *
     * @return string
     */
    public function getPlate4()
    {
        return $this->plate4;
    }

    /**
     * Set cookLevel4
     *
     * @param string $cookLevel4
     *
     * @return Orders
     */
    public function setCookLevel4($cookLevel4)
    {
        $this->cookLevel4 = $cookLevel4;

        return $this;
    }

    /**
     * Get cookLevel4
     *
     * @return string
     */
    public function getCookLevel4()
    {
        return $this->cookLevel4;
    }

    /**
     * Set note4
     *
     * @param string $note4
     *
     * @return Orders
     */
    public function setNote4($note4)
    {
        $this->note4 = $note4;

        return $this;
    }

    /**
     * Get note4
     *
     * @return string
     */
    public function getNote4()
    {
        return $this->note4;
    }
}
