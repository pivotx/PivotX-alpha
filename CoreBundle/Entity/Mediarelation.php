<?php

namespace PivotX\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PivotX\CoreBundle\Util\Tools;

/**
 * PivotX\CoreBundle\Entity\Mediarelation
 *
 * @ORM\Table(name="mediarelation")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Mediarelation
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
     * @var integer $sortingOrder
     *
     * @ORM\Column(name="sorting_order", type="integer", nullable=true)
     */
    private $sortingOrder;

    /**
     * @var Media
     *
     * @ORM\ManyToOne(targetEntity="Media")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     * })
     */
    private $media;

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
     * @var Extrafield
     *
     * @ORM\ManyToOne(targetEntity="Extrafield")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="extrafield_id", referencedColumnName="id")
     * })
     */
    private $extrafield;



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
     * Set sortingOrder
     *
     * @param integer $sortingOrder
     */
    public function setSortingOrder($sortingOrder)
    {
        $this->sortingOrder = $sortingOrder;
    }

    /**
     * Get sortingOrder
     *
     * @return integer
     */
    public function getSortingOrder()
    {
        return $this->sortingOrder;
    }

    /**
     * Set media
     *
     * @param PivotX\CoreBundle\Entity\Media $media
     */
    public function setMedia(\PivotX\CoreBundle\Entity\Media $media)
    {
        $this->media = $media;
    }

    /**
     * Get media
     *
     * @return PivotX\CoreBundle\Entity\Media
     */
    public function getMedia()
    {
        return $this->media;
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

    /**
     * Set extrafield
     *
     * @param PivotX\CoreBundle\Entity\Extrafield $extrafield
     */
    public function setExtrafield(\PivotX\CoreBundle\Entity\Extrafield $extrafield)
    {
        $this->extrafield = $extrafield;
    }

    /**
     * Get extrafield
     *
     * @return PivotX\CoreBundle\Entity\Extrafield
     */
    public function getExtrafield()
    {
        return $this->extrafield;
    }


    public function __toString() {

        return $this->getId();

    }
}