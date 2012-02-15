<?php

namespace PivotX\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PivotX\CoreBundle\Util\Tools;

/**
 * PivotX\CoreBundle\Entity\Session
 *
 * @ORM\Table(name="session")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Session
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
     * @var text $ip
     *
     * @ORM\Column(name="ip", type="text", length=128, nullable=false)
     */
    private $ip;

    /**
     * @var text $sessionkey
     *
     * @ORM\Column(name="sessionkey", type="text", length=128, nullable=false)
     */
    private $sessionkey;

    /**
     * @var datetime $date
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

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
     * Set ip
     *
     * @param text $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * Get ip
     *
     * @return text
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set sessionkey
     *
     * @param text $sessionkey
     */
    public function setSessionkey($sessionkey)
    {
        $this->sessionkey = $sessionkey;
    }

    /**
     * Get sessionkey
     *
     * @return text
     */
    public function getSessionkey()
    {
        return $this->sessionkey;
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

    public function __construct() {
        $this->date = new \DateTime('now');
        $this->ip = $_SERVER['REMOTE_ADDR'];
    }



    public function __toString() {

        return strval($this->getId());

    }
}