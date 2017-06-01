<?php
namespace Acme\TanksBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="Acme\TanksBundle\Repository\CommentsRepository")
 * @ORM\Table(name="comments")
 */	
class comments
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
	protected $theme;
	 /**
     * @ORM\Column(type="text")
     */	
	protected $type;	/**
     * @ORM\Column(type="text")
     */	
	protected $user;
	/**
     * @ORM\Column(type="datetime")
     */	
	protected $date;
	 /**
     * @ORM\Column(type="text")
     */	
	protected $comm;
	 /**
     * @ORM\Column(type="integer")
     */	
	protected $tab;
	 /**
     * @ORM\Column(type="float")
     */	
	protected $rating;

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
     * Set theme
     *
     * @param string $theme
     *
     * @return comments
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get theme
     *
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }
    /**
     * Set type
     *
     * @param string $type
     *
     * @return comments
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
     * Set user
     *
     * @param string $user
     *
     * @return comments
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return comments
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set comm
     *
     * @param string $comm
     *
     * @return comments
     */
    public function setComm($comm)
    {
        $this->comm = $comm;

        return $this;
    }

    /**
     * Get comm
     *
     * @return string
     */
    public function getComm()
    {
        return $this->comm;
    }

    /**
     * Set tab
     *
     * @param integer $tab
     *
     * @return comments
     */
    public function setTab($tab)
    {
        $this->tab = $tab;

        return $this;
    }

    /**
     * Get tab
     *
     * @return integer
     */
    public function getTab()
    {
        return $this->tab;
    }

    /**
     * Set rating
     *
     * @param float $rating
     *
     * @return comments
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return float
     */
    public function getRating()
    {
        return $this->rating;
    }
}
