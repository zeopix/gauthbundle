<?php

namespace Iga\OAuthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Iga\OAuthBundle\Entity\Photo
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Photo
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
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string $path
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var string $googleuser
     *
     * @ORM\Column(name="googleuser", type="bigint")
     */
    private $googleuser;

    /**
     * @var string $googleid
     *
     * @ORM\Column(name="googleid", type="bigint")
     */
    private $googleid;

    /**
     * @var string $createdAt
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;
    
    /**
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="photos")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    private $event;

    

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
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set path
     *
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set googleuser
     *
     * @param string $googleuser
     */
    public function setGoogleuser($googleuser)
    {
        $this->googleuser = $googleuser;
    }

    /**
     * Get googleuser
     *
     * @return string 
     */
    public function getGoogleuser()
    {
        return $this->googleuser;
    }
    
    public function getGoogleid(){
        return $this->googleid;
        
    }
    
    public function setGoogleid($googleid){
        $this->googleid = $googleid;
    }
    
    public function getEvent(){
        return $this->event;
        
    }
    public function setEvent($event){
        $this->event= $event;
        
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
}