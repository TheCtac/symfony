<?php
namespace Acme\TanksBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="Acme\TanksBundle\Repository\RatingsRepository")
 * @ORM\Table(name="ratings")
 */	
class ratings
{
     /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
 	 */
	protected $id;
     /**
     * @ORM\Column(type="integer")
 	 */
	protected $user_id;	
	 /**
     * @ORM\Column(type="integer")
     */
	protected $theme_id;
	 /**
     * @ORM\Column(type="integer", nullable=true)
     */
	protected $comm_id;
	 /**
     * @ORM\Column(type="integer", nullable=true)
     */	
	protected $tanks_id;
	 /**
     * @ORM\Column(type="decimal", precision=11, scale=1)
     */
	protected $value;



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
     * Set userId
     *
     * @param integer $userId
     *
     * @return ratings
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set themeId
     *
     * @param integer $themeId
     *
     * @return ratings
     */
    public function setThemeId($themeId)
    {
        $this->theme_id = $themeId;

        return $this;
    }

    /**
     * Get themeId
     *
     * @return integer
     */
    public function getThemeId()
    {
        return $this->theme_id;
    }

    /**
     * Set commId
     *
     * @param integer $commId
     *
     * @return ratings
     */
    public function setCommId($commId)
    {
        $this->comm_id = $commId;

        return $this;
    }

    /**
     * Get commId
     *
     * @return integer
     */
    public function getCommId()
    {
        return $this->comm_id;
    }

    /**
     * Set tanksId
     *
     * @param integer $tanksId
     *
     * @return ratings
     */
    public function setTanksId($tanksId)
    {
        $this->tanks_id = $tanksId;

        return $this;
    }

    /**
     * Get tanksId
     *
     * @return integer
     */
    public function getTanksId()
    {
        return $this->tanks_id;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return ratings
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
