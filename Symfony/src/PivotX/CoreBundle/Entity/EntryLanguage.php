<?php

namespace PivotX\CoreBundle\Entity;

/**
 */
class EntryLanguage extends \PivotX\Doctrine\Entity\AutoEntity
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var integer $enabled
     */
    private $enabled;

    /**
     * @var string $language
     */
    private $language;

    /**
     * @var string $slug
     */
    private $slug;

    /**
     * @var string $title
     */
    private $title;

    /**
     * @var PivotX\CoreBundle\Entity\Entry
     */
    private $entry;


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
     * Set enabled
     *
     * @param integer $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * Get enabled
     *
     * @return integer 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set language
     *
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * Get language
     *
     * @return string 
     */
    public function getLanguage()
    {
        return $this->language;
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
     * Set entry
     *
     * @param PivotX\CoreBundle\Entity\Entry $entry
     */
    public function setEntry(\PivotX\CoreBundle\Entity\Entry $entry)
    {
        $this->entry = $entry;
    }

    /**
     * Get entry
     *
     * @return PivotX\CoreBundle\Entity\Entry 
     */
    public function getEntry()
    {
        return $this->entry;
    }
}