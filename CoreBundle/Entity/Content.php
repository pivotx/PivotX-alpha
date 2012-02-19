<?php

namespace PivotX\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PivotX\CoreBundle\Util\Tools;

/**
 * PivotX\CoreBundle\Entity\Content
 *
 * @ORM\Table(name="content")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Content
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var text $slug
     *
     * @ORM\Column(name="slug", type="text", length=128, nullable=false)
     */
    private $slug;

    /**
     * @var text $reference
     *
     * @ORM\Column(name="reference", type="text", length=255, nullable=false)
     */
    private $reference;

    /**
     * @var text $grouping
     *
     * @ORM\Column(name="grouping", type="text", length=128, nullable=false)
     */
    private $grouping;

    /**
     * @var text $title
     *
     * @ORM\Column(name="title", type="text", length=255, nullable=false)
     */
    private $title;

    /**
     * @var text $teaser
     *
     * @ORM\Column(name="teaser", type="text", length=65535, nullable=false)
     */
    private $teaser;

    /**
     * @var text $body
     *
     * @ORM\Column(name="body", type="text", length=65535, nullable=false)
     */
    private $body;

    /**
     * @var text $template
     *
     * @ORM\Column(name="template", type="text", length=255, nullable=true)
     */
    private $template;

    /**
     * @var datetime $dateCreated
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=false)
     */
    private $dateCreated;

    /**
     * @var datetime $dateModified
     *
     * @ORM\Column(name="date_modified", type="datetime", nullable=false)
     */
    private $dateModified;

    /**
     * @var datetime $datePublished
     *
     * @ORM\Column(name="date_published", type="datetime", nullable=true)
     */
    private $datePublished;

    /**
     * @var datetime $dateDepublished
     *
     * @ORM\Column(name="date_depublished", type="datetime", nullable=true)
     */
    private $dateDepublished;

    /**
     * @var datetime $datePublishOn
     *
     * @ORM\Column(name="date_publish_on", type="datetime", nullable=true)
     */
    private $datePublishOn;

    /**
     * @var datetime $dateDepublishOn
     *
     * @ORM\Column(name="date_depublish_on", type="datetime", nullable=true)
     */
    private $dateDepublishOn;

    /**
     * @var text $language
     *
     * @ORM\Column(name="language", type="text", length=16, nullable=false)
     */
    private $language;

    /**
     * @var integer $version
     *
     * @ORM\Column(name="version", type="integer", nullable=false)
     */
    private $version;

    /**
     * @var text $status
     *
     * @ORM\Column(name="status", type="text", length=16, nullable=false)
     */
    private $status;

    /**
     * @var boolean $searchable
     *
     * @ORM\Column(name="searchable", type="boolean", nullable=false)
     */
    private $searchable;

    /**
     * @var boolean $locked
     *
     * @ORM\Column(name="locked", type="boolean", nullable=false)
     */
    private $locked;

    /**
     * @var text $originUrl
     *
     * @ORM\Column(name="origin_url", type="text", length=1024, nullable=true)
     */
    private $originUrl;

    /**
     * @var text $originCreator
     *
     * @ORM\Column(name="origin_creator", type="text", length=255, nullable=true)
     */
    private $originCreator;

    /**
     * @var text $textFormatting
     *
     * @ORM\Column(name="text_formatting", type="text", length=255, nullable=false)
     */
    private $textFormatting;

    /**
     * @var boolean $allowResponses
     *
     * @ORM\Column(name="allow_responses", type="boolean", nullable=false)
     */
    private $allowResponses;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var Contenttype
     *
     * @ORM\Column(name="contenttype", type="text", length=255, nullable=true)
     */
    private $contenttype;



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
     * Set slug
     *
     * @param text $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get slug
     *
     * @return text
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set reference
     *
     * @param text $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * Get reference
     *
     * @return text
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set grouping
     *
     * @param text $grouping
     */
    public function setGrouping($grouping)
    {
        $this->grouping = $grouping;
    }

    /**
     * Get grouping
     *
     * @return text
     */
    public function getGrouping()
    {
        return $this->grouping;
    }

    /**
     * Set title
     *
     * @param text $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return text
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set teaser
     *
     * @param text $teaser
     */
    public function setTeaser($teaser)
    {
        $this->teaser = $teaser;
    }

    /**
     * Get teaser
     *
     * @return text
     */
    public function getTeaser()
    {
        return $this->teaser;
    }


    /**
     * Get excerpt
     *
     * @return text
     */
    public function getExcerpt()
    {

        $this->excerpt = Tools::makeExcerpt($this->teaser . $this->body, 400);

        return $this->excerpt;
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

    /**
     * Set template
     *
     * @param text $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * Get template
     *
     * @return text
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set dateCreated
     *
     * @param datetime $dateCreated
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    }

    /**
     * Get dateCreated
     *
     * @return datetime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set dateModified
     *
     * @param datetime $dateModified
     */
    public function setDateModified($dateModified)
    {
        $this->dateModified = $dateModified;
    }

    /**
     * Get dateModified
     *
     * @return datetime
     */
    public function getDateModified()
    {
        return $this->dateModified;
    }

    /**
     * Set datePublished
     *
     * @param datetime $datePublished
     */
    public function setDatePublished($datePublished)
    {
        $this->datePublished = $datePublished;
    }

    /**
     * Get datePublished
     *
     * @return datetime
     */
    public function getDatePublished()
    {
        return $this->datePublished;
    }

    /**
     * Set dateDepublished
     *
     * @param datetime $dateDepublished
     */
    public function setDateDepublished($dateDepublished)
    {
        $this->dateDepublished = $dateDepublished;
    }

    /**
     * Get dateDepublished
     *
     * @return datetime
     */
    public function getDateDepublished()
    {
        return $this->dateDepublished;
    }

    /**
     * Set datePublishOn
     *
     * @param datetime $datePublishOn
     */
    public function setDatePublishOn($datePublishOn)
    {
        $this->datePublishOn = $datePublishOn;
    }

    /**
     * Get datePublishOn
     *
     * @return datetime
     */
    public function getDatePublishOn()
    {
        return $this->datePublishOn;
    }

    /**
     * Set dateDepublishOn
     *
     * @param datetime $dateDepublishOn
     */
    public function setDateDepublishOn($dateDepublishOn)
    {
        $this->dateDepublishOn = $dateDepublishOn;
    }

    /**
     * Get dateDepublishOn
     *
     * @return datetime
     */
    public function getDateDepublishOn()
    {
        return $this->dateDepublishOn;
    }

    /**
     * Set language
     *
     * @param text $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * Get language
     *
     * @return text
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set version
     *
     * @param integer $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * Get version
     *
     * @return integer
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set status
     *
     * @param text $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return text
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set searchable
     *
     * @param boolean $searchable
     */
    public function setSearchable($searchable)
    {
        $this->searchable = $searchable;
    }

    /**
     * Get searchable
     *
     * @return boolean
     */
    public function getSearchable()
    {
        return $this->searchable;
    }

    /**
     * Set locked
     *
     * @param boolean $locked
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;
    }

    /**
     * Get locked
     *
     * @return boolean
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * Set originUrl
     *
     * @param text $originUrl
     */
    public function setOriginUrl($originUrl)
    {
        $this->originUrl = $originUrl;
    }

    /**
     * Get originUrl
     *
     * @return text
     */
    public function getOriginUrl()
    {
        return $this->originUrl;
    }

    /**
     * Set originCreator
     *
     * @param text $originCreator
     */
    public function setOriginCreator($originCreator)
    {
        $this->originCreator = $originCreator;
    }

    /**
     * Get originCreator
     *
     * @return text
     */
    public function getOriginCreator()
    {
        return $this->originCreator;
    }

    /**
     * Set textFormatting
     *
     * @param text $textFormatting
     */
    public function setTextFormatting($textFormatting)
    {
        $this->textFormatting = $textFormatting;
    }

    /**
     * Get textFormatting
     *
     * @return text
     */
    public function getTextFormatting()
    {
        return $this->textFormatting;
    }

    /**
     * Set allowResponses
     *
     * @param boolean $allowResponses
     */
    public function setAllowResponses($allowResponses)
    {
        $this->allowResponses = $allowResponses;
    }

    /**
     * Get allowResponses
     *
     * @return boolean
     */
    public function getAllowResponses()
    {
        return $this->allowResponses;
    }

    /**
     * Set user
     *
     * @param PivotX\CoreBundle\Entity\User $user
     */
    public function setUser(\PivotX\CoreBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return PivotX\CoreBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set contenttype
     *
     * @param text $contenttype
     */
    public function setContenttype($contenttype)
    {
        $this->contenttype = $contenttype;
    }

    /**
     * Get contenttype
     *
     * @return text
     */
    public function getContenttype()
    {
        return $this->contenttype;
    }

    public function __construct() {
        $this->dateCreated = new \DateTime('now');
        $this->dateModified = new \DateTime('now');
    }

    public function __toString() {

        return $this->getReference();

    }

    /**
     * @ORM\preUpdate
     * @ORM\prePersist
     */
    public function setUpdatedValue()
    {

        $this->dateModified = new \DateTime('now');

        $this->setVersion($this->getVersion()+1);

        // Set the slug.
        if ($this->slug == "" ) {
            $this->slug = Tools::makeSlug($this->title);
        }

        // Set the reference.
        $this->reference = Tools::makeReference("content", array(
            'type' => $this->getContenttype(),
            'slug' => $this->slug,
            'id' => $this->id,
            'language' => $this->language,
            'grouping' => $this->grouping
        ));

    }


}