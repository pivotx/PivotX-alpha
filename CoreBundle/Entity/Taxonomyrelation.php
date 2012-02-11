<?php

namespace PivotX\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PivotX\CoreBundle\Entity\Taxonomyrelation
 *
 * @ORM\Table(name="taxonomyrelation")
 * @ORM\Entity
 */
class Taxonomyrelation
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
     * @ORM\Column(name="sorting_order", type="integer", nullable=false)
     */
    private $sortingOrder;


    /**
     * @var Taxonomyrelation
     *
     * @ORM\ManyToOne(targetEntity="Taxonomyrelation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     * })
     */
    private $parent;

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
     * @var Taxonomy
     *
     * @ORM\ManyToOne(targetEntity="Taxonomy")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="taxonomy_id", referencedColumnName="id")
     * })
     */
    private $taxonomy;



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
     * Set parentId
     *
     * @param integer $parentId
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    }

    /**
     * Get parentId
     *
     * @return integer
     */
    public function getParentId()
    {
        return $this->parentId;
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
     * Set taxonomy
     *
     * @param PivotX\CoreBundle\Entity\Taxonomy $taxonomy
     */
    public function setTaxonomy(\PivotX\CoreBundle\Entity\Taxonomy $taxonomy)
    {
        $this->taxonomy = $taxonomy;
    }

    /**
     * Get taxonomy
     *
     * @return PivotX\CoreBundle\Entity\Taxonomy
     */
    public function getTaxonomy()
    {
        return $this->taxonomy;
    }
}