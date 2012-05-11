<?php

namespace PivotX\CoreBundle\Entity;

/**
 */
class Entry extends \PivotX\Doctrine\Entity\AutoEntity
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var integer $resource_id
     */
    private $resource_id;

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
     * @var integer $viewable
     */
    private $viewable;

    /**
     * @var string $publish_state
     */
    private $publish_state;

    /**
     * @var datetime $publish_on
     */
    private $publish_on;

    /**
     * @var datetime $depublish_on
     */
    private $depublish_on;

    /**
     * @var string $version
     */
    private $version;

    /**
     * @var PivotX\CoreBundle\Entity\EntryLanguage
     */
    private $languages;

    public function __construct()
    {
        $this->languages = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set resource_id
     *
     * @param integer $resourceId
     */
    public function setResourceId($resourceId)
    {
        $this->resource_id = $resourceId;
    }

    /**
     * Get resource_id
     *
     * @return integer 
     */
    public function getResourceId()
    {
        return $this->resource_id;
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
     * Set viewable
     *
     * @param integer $viewable
     */
    public function setViewable($viewable)
    {
        $this->viewable = $viewable;
    }

    /**
     * Get viewable
     *
     * @return integer 
     */
    public function getViewable()
    {
        return $this->viewable;
    }

    /**
     * Set publish_state
     *
     * @param string $publishState
     */
    public function setPublishState($publishState)
    {
        $this->publish_state = $publishState;
    }

    /**
     * Get publish_state
     *
     * @return string 
     */
    public function getPublishState()
    {
        return $this->publish_state;
    }

    /**
     * Set publish_on
     *
     * @param datetime $publishOn
     */
    public function setPublishOn($publishOn)
    {
        $this->publish_on = $publishOn;
    }

    /**
     * Get publish_on
     *
     * @return datetime 
     */
    public function getPublishOn()
    {
        return $this->publish_on;
    }

    /**
     * Set depublish_on
     *
     * @param datetime $depublishOn
     */
    public function setDepublishOn($depublishOn)
    {
        $this->depublish_on = $depublishOn;
    }

    /**
     * Get depublish_on
     *
     * @return datetime 
     */
    public function getDepublishOn()
    {
        return $this->depublish_on;
    }

    /**
     * Set version
     *
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * Get version
     *
     * @return string 
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Add languages
     *
     * @param PivotX\CoreBundle\Entity\EntryLanguage $languages
     */
    public function addEntryLanguage(\PivotX\CoreBundle\Entity\EntryLanguage $languages)
    {
        $this->languages[] = $languages;
    }

    /**
     * Get languages
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getLanguages()
    {
        return $this->languages;
    }
}
