<?php

namespace TwoKings\Bundle\EBikeBundle\Entity;

/**
 */
class TranslationText extends \PivotX\Doctrine\Entity\AutoEntity
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
}
