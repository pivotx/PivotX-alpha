<?php

namespace PivotX\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PivotX\CoreBundle\Entity\User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User
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
     * @var text $role
     *
     * @ORM\Column(name="role", type="text", length=128, nullable=false)
     */
    private $role;

    /**
     * @var text $email
     *
     * @ORM\Column(name="email", type="text", length=128, nullable=false)
     */
    private $email;

    /**
     * @var text $password
     *
     * @ORM\Column(name="password", type="text", length=255, nullable=false)
     */
    private $password;

    /**
     * @var text $nickname
     *
     * @ORM\Column(name="nickname", type="text", length=255, nullable=false)
     */
    private $nickname;

    /**
     * @var text $fullname
     *
     * @ORM\Column(name="fullname", type="text", length=255, nullable=false)
     */
    private $fullname;

    /**
     * @var text $language
     *
     * @ORM\Column(name="language", type="text", length=16, nullable=false)
     */
    private $language;

    /**
     * @var datetime $dateLastseen
     *
     * @ORM\Column(name="date_lastseen", type="datetime", nullable=false)
     */
    private $dateLastseen;

    /**
     * @var text $ipLastseen
     *
     * @ORM\Column(name="ip_lastseen", type="text", length=128, nullable=false)
     */
    private $ipLastseen;

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
     * Set role
     *
     * @param text $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * Get role
     *
     * @return text
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set email
     *
     * @param text $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return text
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param text $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return text
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set nickname
     *
     * @param text $nickname
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }

    /**
     * Get nickname
     *
     * @return text
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set fullname
     *
     * @param text $fullname
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
    }

    /**
     * Get fullname
     *
     * @return text
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * Set language
     *
     * @param text $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * Get language
     *
     * @return text
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set dateLastseen
     *
     * @param datetime $dateLastseen
     */
    public function setDateLastseen($dateLastseen)
    {
        $this->dateLastseen = $dateLastseen;
    }

    /**
     * Get dateLastseen
     *
     * @return datetime
     */
    public function getDateLastseen()
    {
        return $this->dateLastseen;
    }

    /**
     * Set ipLastseen
     *
     * @param text $ipLastseen
     */
    public function setIpLastseen($ipLastseen)
    {
        $this->ipLastseen = $ipLastseen;
    }

    /**
     * Get ipLastseen
     *
     * @return text
     */
    public function getIpLastseen()
    {
        return $this->ipLastseen;
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

    public function __toString() {

        return $this->getFullname();

    }

}