<?php

namespace PivotX\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PivotX\CoreBundle\Entity\Userpermission
 *
 * @ORM\Table(name="userpermission")
 * @ORM\Entity
 */
class Userpermission
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
     * @var Permission
     *
     * @ORM\ManyToOne(targetEntity="Permission")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="permission_id", referencedColumnName="id")
     * })
     */
    private $permission;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set permission
     *
     * @param PivotX\CoreBundle\Entity\Permission $permission
     */
    public function setPermission(\PivotX\CoreBundle\Entity\Permission $permission)
    {
        $this->permission = $permission;
    }

    /**
     * Get permission
     *
     * @return PivotX\CoreBundle\Entity\Permission
     */
    public function getPermission()
    {
        return $this->permission;
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


    public function __toString() {

        return $this->getId();

    }
    
}