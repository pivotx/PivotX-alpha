<?php

namespace PivotX\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PivotX\CoreBundle\Entity\Taxonomy
 *
 * @ORM\Table(name="taxonomy")
 * @ORM\Entity
 */
class Taxonomy
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
     * @var Taxonomy
     *
     * @ORM\ManyToOne(targetEntity="Taxonomytype")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="taxonomytype_id", referencedColumnName="id")
     * })
     */
    private $taxonomytype;


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
     * @var text $name
     *
     * @ORM\Column(name="name", type="text", length=255, nullable=false)
     */
    private $name;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text", length=255, nullable=false)
     */
    private $description;

    /**
     * @var integer $parentId
     *
     * @ORM\Column(name="parent_id", type="integer", nullable=true)
     */
    private $parentId;

    /**
     * @var integer $sortingOrder
     *
     * @ORM\Column(name="sorting_order", type="integer", nullable=false)
     */
    private $sortingOrder;




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
     * Set name
     *
     * @param text $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return text
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text
     */
    public function getDescription()
    {
        return $this->description;
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
     * Set taxonomytype
     *
     * @param PivotX\CoreBundle\Entity\Taxonomy $taxonomytype
     */
    public function setTaxonomytype(\PivotX\CoreBundle\Entity\Taxonomy $taxonomytype)
    {
        $this->taxonomytype = $taxonomytype;
    }

    /**
     * Get taxonomytype
     *
     * @return PivotX\CoreBundle\Entity\Taxonomy
     */
    public function getTaxonomytype()
    {
        return $this->taxonomytype;
    }
}