<?php

namespace Google\PlusBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Google\PlusBundle\Entity\GoogleUser
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class GoogleUser
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $kind
     *
     * @ORM\Column(name="kind", type="string", length=255)
     */
    private $kind;

    /**
     * @var bigint $googleid
     *
     * @ORM\Column(name="googleid", type="bigint")
     */
    private $googleid;

    /**
     * @var string $gender
     *
     * @ORM\Column(name="gender", type="string", length=30)
     */
    private $gender;

    /**
     * @var string $displayName
     *
     * @ORM\Column(name="displayName", type="string", length=200)
     */
    private $displayName;

    /**
     * @var \DateTime $createdAt
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime $updatedAt
     *
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;

    /**
     * @var \DateTime $loggedAt
     *
     * @ORM\Column(name="loggedAt", type="datetime")
     */
    private $loggedAt;

    /**
     * @var string $aboutMe
     *
     * @ORM\Column(name="aboutMe", type="string", length=255)
     */
    private $aboutMe;

    /**
     * @var string $url
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string $image
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;


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
     * Set kind
     *
     * @param string $kind
     */
    public function setKind($kind)
    {
        $this->kind = $kind;
    }

    /**
     * Get kind
     *
     * @return string 
     */
    public function getKind()
    {
        return $this->kind;
    }

    /**
     * Set googleid
     *
     * @param bigint $googleid
     */
    public function setGoogleid($googleid)
    {
        $this->googleid = $googleid;
    }

    /**
     * Get googleid
     *
     * @return bigint 
     */
    public function getGoogleid()
    {
        return $this->googleid;
    }

    /**
     * Set gender
     *
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set aboutMe
     *
     * @param string $aboutMe
     */
    public function setAboutMe($aboutMe)
    {
        $this->aboutMe = $aboutMe;
    }

    /**
     * Get aboutMe
     *
     * @return string 
     */
    public function getAboutMe()
    {
        return $this->aboutMe;
    }

    /**
     * Set url
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set image
     *
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set displayName
     *
     * @param string $displayName
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }

    /**
     * Get displayName
     *
     * @return string 
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get updatedAt
     *
     * @return datetime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set loggedAt
     *
     * @param datetime $loggedAt
     */
    public function setLoggedAt($loggedAt)
    {
        $this->loggedAt = $loggedAt;
    }

    /**
     * Get loggedAt
     *
     * @return datetime 
     */
    public function getLoggedAt()
    {
        return $this->loggedAt;
    }
}