<?php

namespace TwoKings\Bundle\EBikeBundle\Entity;

/**
 */
//class TranslationText extends \PivotX\Doctrine\Entity\AutoEntity
class TranslationText 
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $sitename
     */
    private $sitename;

    /**
     * @var string $groupname
     */
    private $groupname;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var datetime $date_created
     */
    private $date_created;

    /**
     * @var datetime $date_modified
     */
    private $date_modified;

    /**
     * @var string $encoding
     */
    private $encoding;

    /**
     * @var string $text_nl
     */
    private $text_nl;

    /**
     * @var string $text_en
     */
    private $text_en;

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
     * Set sitename
     *
     * @param string $sitename
     */
    public function setSitename($sitename)
    {
        $this->sitename = $sitename;
    }

    /**
     * Get sitename
     *
     * @return string 
     */
    public function getSitename()
    {
        return $this->sitename;
    }

    /**
     * Set groupname
     *
     * @param string $groupname
     */
    public function setGroupname($groupname)
    {
        $this->groupname = $groupname;
    }

    /**
     * Get groupname
     *
     * @return string 
     */
    public function getGroupname()
    {
        return $this->groupname;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
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
     * Set encoding
     *
     * @param string $encoding
     */
    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
    }

    /**
     * Get encoding
     *
     * @return string 
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * Set text_nl
     *
     * @param text $textNl
     */
    public function setTextNl($textNl)
    {
        $this->text_nl = $textNl;
    }

    /**
     * Get text_nl
     *
     * @return text 
     */
    public function getTextNl()
    {
        return $this->text_nl;
    }

    /**
     * Set text_en
     *
     * @param text $textEn
     */
    public function setTextEn($textEn)
    {
        $this->text_en = $textEn;
    }

    /**
     * Get text_en
     *
     * @return text 
     */
    public function getTextEn()
    {
        return $this->text_en;
    }
}
