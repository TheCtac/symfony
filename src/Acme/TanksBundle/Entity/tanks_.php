<?php
namespace Acme\TanksBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="Acme\TanksBundle\Repository\Tanks_Repository")
 * @ORM\Table(name="tanks_")
 */	
class tanks_
{
	 /**
     * @ORM\Id
     * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
     */
	protected $id;
	 /**
     * @ORM\Column(type="text")
     */	
	protected $name;
	 /**
     * @ORM\Column(type="text")
     */		
	protected $type;
	 /**
     * @ORM\Column(type="integer")
     */	
	protected $level;
	 /**
     * @ORM\Column(type="decimal")
     */	
	protected $armo;
	 /**
     * @ORM\Column(type="decimal")
     */	
	protected $guns;
	 /**
     * @ORM\Column(type="decimal")
     */	
	protected $speed;
	 /**
     * @ORM\Column(type="text")
     */		
	protected $photo;
	 /**
     * @ORM\Column(type="text")
     */		
	protected $history;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return tanks_
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return tanks_
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return tanks_
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set armo
     *
     * @param string $armo
     *
     * @return tanks_
     */
    public function setArmo($armo)
    {
        $this->armo = $armo;

        return $this;
    }

    /**
     * Get armo
     *
     * @return string
     */
    public function getArmo()
    {
        return $this->armo;
    }

    /**
     * Set guns
     *
     * @param string $guns
     *
     * @return tanks_
     */
    public function setGuns($guns)
    {
        $this->guns = $guns;

        return $this;
    }

    /**
     * Get guns
     *
     * @return string
     */
    public function getGuns()
    {
        return $this->guns;
    }

    /**
     * Set speed
     *
     * @param string $speed
     *
     * @return tanks_
     */
    public function setSpeed($speed)
    {
        $this->speed = $speed;

        return $this;
    }

    /**
     * Get speed
     *
     * @return string
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return tanks_
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set history
     *
     * @param string $history
     *
     * @return tanks_
     */
    public function setHistory($history)
    {
        $this->history = $history;

        return $this;
    }

    /**
     * Get history
     *
     * @return string
     */
    public function getHistory()
    {
        return $this->history;
    }
}
