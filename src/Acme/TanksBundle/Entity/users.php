<?php
namespace Acme\TanksBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="Acme\TanksBundle\Repository\UsersRepository")
 * @ORM\Table(name="users")
 */	
class users
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
	protected $login;
	 /**
     * @ORM\Column(type="text")
     */		
	protected $pass;
	 /**
     * @ORM\Column(type="text")
     */	
	protected $email;
	 /**
     * @ORM\Column(type="text")
     */	
	protected $photo;
	 /**
     * @ORM\Column(type="text")
     */	
	protected $about;
	 /**
     * @ORM\Column(type="integer")
     */	
	protected $age;
	 /**
     * @ORM\Column(type="text")
     */		
	protected $city;
	 /**
     * @ORM\Column(type="text")
     */		
	protected $male;
	 /**
     * @ORM\Column(type="text")
     */	
	protected $hash;
	 /**
     * @ORM\Column(type="date")
     */	
	protected $date;
	 /**
     * @ORM\Column(type="decimal")
     */	
	protected $rating;
	 /**
     * @ORM\Column(type="text")
     */	
	protected $liked_tags;
	 /**
     * @ORM\Column(type="decimal")
     */		
	protected $voit;
	 /**
     * @ORM\Column(type="integer")
     */		
	protected $active;

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
     * Set login
     *
     * @param string $login
     *
     * @return users
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set pass
     *
     * @param string $pass
     *
     * @return users
     */
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * Get pass
     *
     * @return string
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return users
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
     * Set photo
     *
     * @param string $photo
     *
     * @return users
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
     * Set about
     *
     * @param string $about
     *
     * @return users
     */
    public function setAbout($about)
    {
        $this->about = $about;

        return $this;
    }

    /**
     * Get about
     *
     * @return string
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return users
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return users
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set male
     *
     * @param string $male
     *
     * @return users
     */
    public function setMale($male)
    {
        $this->male = $male;

        return $this;
    }

    /**
     * Get male
     *
     * @return string
     */
    public function getMale()
    {
        return $this->male;
    }

    /**
     * Set hash
     *
     * @param string $hash
     *
     * @return users
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get hash
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return users
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
     * Set rating
     *
     * @param string $rating
     *
     * @return users
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return string
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set likedTags
     *
     * @param string $likedTags
     *
     * @return users
     */
    public function setLikedTags($likedTags)
    {
        $this->liked_tags = $likedTags;

        return $this;
    }

    /**
     * Get likedTags
     *
     * @return string
     */
    public function getLikedTags()
    {
        return $this->liked_tags;
    }

    /**
     * Set voit
     *
     * @param string $voit
     *
     * @return users
     */
    public function setVoit($voit)
    {
        $this->voit = $voit;

        return $this;
    }

    /**
     * Get voit
     *
     * @return string
     */
    public function getVoit()
    {
        return $this->voit;
    }

    /**
     * Set active
     *
     * @param integer $active
     *
     * @return users
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return integer
     */
    public function getActive()
    {
        return $this->active;
    }
}
