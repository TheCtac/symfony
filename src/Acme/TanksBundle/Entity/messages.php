<?php
namespace Acme\TanksBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="Acme\TanksBundle\Repository\MessagesRepository")
 * @ORM\Table(name="messages")
 */	
class messages
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
	protected $from_id;	
	 /**
     * @ORM\Column(type="integer")
     */
	protected $to_id;
	 /**
     * @ORM\Column(type="text")
     */
	protected $body;
	 /**
     * @ORM\Column(type="integer")
     */	
	protected $type_mess;
	 /**
     * @ORM\Column(type="datetime")
     */
	protected $send_date;
	 /**
     * @ORM\Column(type="datetime")
     */
	protected $res_date;
	 /**
     * @ORM\Column(type="text")
     */
	protected $theme;


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
     * Set fromId
     *
     * @param integer $fromId
     *
     * @return messages
     */
    public function setFromId($fromId)
    {
        $this->from_id = $fromId;

        return $this;
    }

    /**
     * Get fromId
     *
     * @return integer
     */
    public function getFromId()
    {
        return $this->from_id;
    }

    /**
     * Set toId
     *
     * @param integer $toId
     *
     * @return messages
     */
    public function setToId($toId)
    {
        $this->to_id = $toId;

        return $this;
    }

    /**
     * Get toId
     *
     * @return integer
     */
    public function getToId()
    {
        return $this->to_id;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return messages
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set typeMess
     *
     * @param integer $typeMess
     *
     * @return messages
     */
    public function setTypeMess($typeMess)
    {
        $this->type_mess = $typeMess;

        return $this;
    }

    /**
     * Get typeMess
     *
     * @return integer
     */
    public function getTypeMess()
    {
        return $this->type_mess;
    }

    /**
     * Set sendDate
     *
     * @param \DateTime $sendDate
     *
     * @return messages
     */
    public function setSendDate($sendDate)
    {
        $this->send_date = $sendDate;

        return $this;
    }

    /**
     * Get sendDate
     *
     * @return \DateTime
     */
    public function getSendDate()
    {
        return $this->send_date;
    }

    /**
     * Set resDate
     *
     * @param \DateTime $resDate
     *
     * @return messages
     */
    public function setResDate($resDate)
    {
        $this->res_date = $resDate;

        return $this;
    }

    /**
     * Get resDate
     *
     * @return \DateTime
     */
    public function getResDate()
    {
        return $this->res_date;
    }

    /**
     * Set theme
     *
     * @param string $theme
     *
     * @return messages
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
}
