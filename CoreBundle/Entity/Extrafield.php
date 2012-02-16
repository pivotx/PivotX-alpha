<?php

namespace PivotX\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PivotX\CoreBundle\Util\Tools;

/**
 * PivotX\CoreBundle\Entity\Extrafield
 *
 * @ORM\Table(name="extrafield")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Extrafield
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
     * @var text $fieldkey
     *
     * @ORM\Column(name="fieldkey", type="text", length=255, nullable=false)
     */
    private $fieldkey;

    /**
     * @var text $textValue
     *
     * @ORM\Column(name="text_value", type="text", length=65535, nullable=true)
     */
    private $textValue;

    /**
     * @var float $floatValue
     *
     * @ORM\Column(name="float_value", type="float", nullable=true)
     */
    private $floatValue;

    /**
     * @var datetime $dateValue
     *
     * @ORM\Column(name="date_value", type="datetime", nullable=true)
     */
    private $dateValue;


    /**
     * @var datetime $date
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var text $originCreator
     *
     * @ORM\Column(name="origin_creator", type="text", length=255, nullable=true)
     */
    private $originCreator;

    /**
     * @var Contenttype
     *
     * @ORM\Column(name="contenttype", type="text", length=255, nullable=true)
     */
    private $contenttype;

    /**
     * @var Content
     *
     * @ORM\ManyToOne(targetEntity="Content")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="content_id", referencedColumnName="id")
     * })
     */
    private $content;



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
     * Set fieldkey
     *
     * @param text $fieldkey
     */
    public function setFieldkey($fieldkey)
    {
        $this->fieldkey = $fieldkey;
    }

    /**
     * Get fieldkey
     *
     * @return text
     */
    public function getFieldkey()
    {
        return $this->fieldkey;
    }

    /**
     * Set textValue
     *
     * @param text $textValue
     */
    public function setTextValue($textValue)
    {
        $this->textValue = $textValue;
    }

    /**
     * Get textValue
     *
     * @return text
     */
    public function getTextValue()
    {
        return $this->textValue;
    }

    /**
     * Set floatValue
     *
     * @param float $floatValue
     */
    public function setFloatValue($floatValue)
    {
        $this->floatValue = $floatValue;
    }

    /**
     * Get floatValue
     *
     * @return float
     */
    public function getFloatValue()
    {
        return $this->floatValue;
    }

    /**
     * Set dateValue
     *
     * @param datetime $dateValue
     */
    public function setDateValue($dateValue)
    {
        $this->dateValue = $dateValue;
    }

    /**
     * Get dateValue
     *
     * @return datetime
     */
    public function getDateValue()
    {
        return $this->dateValue;
    }

    /**
     * Set date
     *
     * @param datetime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return datetime
     */
    public function getDate()
    {
        return $this->date;
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


    /**
     * Set content
     *
     * @param PivotX\CoreBundle\Entity\Content $content
     */
    public function setContent(\PivotX\CoreBundle\Entity\Content $content)
    {
        $this->content = $content;
    }

    /**
     * Get content
     *
     * @return PivotX\CoreBundle\Entity\Content
     */
    public function getContent()
    {
        return $this->content;
    }


    public function __construct() {
        $this->date = new \DateTime('now');
    }


    public function __toString() {

        return $this->getFieldkey() . " - " . $this->getTextValue();

    }

    /**
     * @ORM\preUpdate
     * @ORM\prePersist
     */
    public function setUpdatedValue()
    {

    }

}