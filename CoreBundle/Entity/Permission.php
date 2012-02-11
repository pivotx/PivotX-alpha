<?php

namespace PivotX\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PivotX\CoreBundle\Entity\Permission
 *
 * @ORM\Table(name="permission")
 * @ORM\Entity
 */
class Permission
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
     * @var text $type
     *
     * @ORM\Column(name="type", type="text", nullable=false)
     */
    private $type;

    /**
     * @var Contenttype
     *
     * @ORM\ManyToOne(targetEntity="Contenttype")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contenttype_id", referencedColumnName="id")
     * })
     */
    private $contenttype;


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
     * @var integer $editUsers
     *
     * @ORM\Column(name="edit_users", type="integer", nullable=false)
     */
    private $editUsers;

    /**
     * @var integer $value
     *
     * @ORM\Column(name="value", type="integer", nullable=false)
     */
    private $value;



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
     * Set type
     *
     * @param text $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return text
     */
    public function getType()
    {
        return $this->type;
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
     * Set taxonomyId
     *
     * @param integer $taxonomyId
     */
    public function setTaxonomyId($taxonomyId)
    {
        $this->taxonomyId = $taxonomyId;
    }

    /**
     * Get taxonomyId
     *
     * @return integer
     */
    public function getTaxonomyId()
    {
        return $this->taxonomyId;
    }

    /**
     * Set editUsers
     *
     * @param integer $editUsers
     */
    public function setEditUsers($editUsers)
    {
        $this->editUsers = $editUsers;
    }

    /**
     * Get editUsers
     *
     * @return integer
     */
    public function getEditUsers()
    {
        return $this->editUsers;
    }

    /**
     * Set value
     *
     * @param integer $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }
}