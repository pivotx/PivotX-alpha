<?php

namespace TwoKings\Bundle\EBikeBundle\Entity;

/**
 */
class Brand extends \PivotX\Doctrine\Entity\AutoEntity
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $publicid
     */
    private $publicid;

    /**
     * @var datetime $date_created
     */
    private $date_created;

    /**
     * @var datetime $date_modified
     */
    private $date_modified;

    /**
     * @var string $title
     */
    private $title;

    /**
     * @var TwoKings\Bundle\EBikeBundle\Entity\Bike
     */
    private $bikes;

    public function __construct()
    {
        $this->bikes = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set publicid
     *
     * @param string $publicid
     */
    public function setPublicid($publicid)
    {
        $this->publicid = $publicid;
    }

    /**
     * Get publicid
     *
     * @return string 
     */
    public function getPublicid()
    {
        return $this->publicid;
    }

    /**
     * Set date_created
     *
     * @param datetime $dateCreated
     */
    public function setDateCreated($dateCreated)
    {
        $this->date_created = $dateCreated;
    }

    /**
     * Get date_created
     *
     * @return datetime 
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * Set date_modified
     *
     * @param datetime $dateModified
     */
    public function setDateModified($dateModified)
    {
        $this->date_modified = $dateModified;
    }

    /**
     * Get date_modified
     *
     * @return datetime 
     */
    public function getDateModified()
    {
        return $this->date_modified;
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
     * Add bikes
     *
     * @param TwoKings\Bundle\EBikeBundle\Entity\Bike $bikes
     */
    public function addBike(\TwoKings\Bundle\EBikeBundle\Entity\Bike $bikes)
    {
        $this->bikes[] = $bikes;
    }

    /**
     * Get bikes
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getBikes()
    {
        return $this->bikes;
    }
}