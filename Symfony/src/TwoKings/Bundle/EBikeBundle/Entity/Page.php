<?php

namespace TwoKings\Bundle\EBikeBundle\Entity;

/**
 */
class Page extends \PivotX\Doctrine\Entity\AutoEntity
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
     * @var string $title
     */
    private $title;

    /**
     * @var text $body
     */
    private $body;


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
     * Set body
     *
     * @param text $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * Get body
     *
     * @return text 
     */
    public function getBody()
    {
        return $this->body;
    }
}