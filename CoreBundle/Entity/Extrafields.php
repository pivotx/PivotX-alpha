<?php

namespace PivotX\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PivotX\CoreBundle\Entity\Extrafields
 *
 * @ORM\Table(name="extrafields")
 * @ORM\Entity
 */
class Extrafields
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
     * @var integer $contentId
     *
     * @ORM\ManyToOne(targetEntity="Content")
     * @ORM\JoinColumn(name="content_id", referencedColumnName="id")
     */
    private $contentId;

    /**
     * @var integer $contenttypeId
     *
     * @ORM\Column(name="contenttype_id", type="integer", nullable=false)
     */
    private $contenttypeId;

    /**
     * @var text $fieldkey
     *
     * @ORM\Column(name="fieldkey", type="text", nullable=false)
     */
    private $fieldkey;

    /**
     * @var text $textValue
     *
     * @ORM\Column(name="text_value", type="text", nullable=false)
     */
    private $textValue;

    /**
     * @var float $floatValue
     *
     * @ORM\Column(name="float_value", type="float", nullable=false)
     */
    private $floatValue;

    /**
     * @var datetime $dateValue
     *
     * @ORM\Column(name="date_value", type="datetime", nullable=false)
     */
    private $dateValue;

    /**
     * @var integer $mediaId
     *
     * @ORM\Column(name="media_id", type="integer", nullable=false)
     */
    private $mediaId;

    /**
     * @var text $originCreator
     *
     * @ORM\Column(name="origin_creator", type="text", nullable=false)
     */
    private $originCreator;



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
     * Set contentId
     *
     * @param integer $contentId
     */
    public function setContentId($contentId)
    {
        $this->contentId = $contentId;
    }

    /**
     * Get contentId
     *
     * @return integer 
     */
    public function getContentId()
    {
        return $this->contentId;
    }

    /**
     * Set contenttypeId
     *
     * @param integer $contenttypeId
     */
    public function setContenttypeId($contenttypeId)
    {
        $this->contenttypeId = $contenttypeId;
    }

    /**
     * Get contenttypeId
     *
     * @return integer 
     */
    public function getContenttypeId()
    {
        return $this->contenttypeId;
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
     * Set mediaId
     *
     * @param integer $mediaId
     */
    public function setMediaId($mediaId)
    {
        $this->mediaId = $mediaId;
    }

    /**
     * Get mediaId
     *
     * @return integer 
     */
    public function getMediaId()
    {
        return $this->mediaId;
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
}