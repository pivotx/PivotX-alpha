<?php

namespace TwoKings\Bundle\EBikeBundle\Entity;

/**
 */
//class BikeReview extends \PivotX\Doctrine\Entity\AutoEntity
class BikeReview
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var datetime $date_created
     */
    private $date_created;

    /**
     * @var datetime $date_modified
     */
    private $date_modified;

    /**
     * @var integer $viewable
     */
    private $viewable;

    /**
     * @var text $comment_status
     */
    private $comment_status;

    /**
     * @var text $remote_addr
     */
    private $remote_addr;

    /**
     * @var text $http_user_agent
     */
    private $http_user_agent;

    /**
     * @var text $name
     */
    private $name;

    /**
     * @var text $email
     */
    private $email;

    /**
     * @var text $comment
     */
    private $comment;

    /**
     * @var TwoKings\Bundle\EBikeBundle\Entity\Bike
     */
    private $bike;


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
     * Set viewable
     *
     * @param integer $viewable
     */
    public function setViewable($viewable)
    {
        $this->viewable = $viewable;
    }

    /**
     * Get viewable
     *
     * @return integer 
     */
    public function getViewable()
    {
        return $this->viewable;
    }

    /**
     * Set comment
     *
     * @param text $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get comment
     *
     * @return text 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set reviews
     *
     * @param TwoKings\Bundle\EBikeBundle\Entity\Bike $reviews
     */
    public function setReviews(\TwoKings\Bundle\EBikeBundle\Entity\Bike $reviews)
    {
        $this->reviews = $reviews;
    }

    /**
     * Get reviews
     *
     * @return TwoKings\Bundle\EBikeBundle\Entity\Bike 
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    /**
     * Set comment_status
     *
     * @param string $commentStatus
     */
    public function setCommentStatus($commentStatus)
    {
        $this->comment_status = $commentStatus;
    }

    /**
     * Get comment_status
     *
     * @return string 
     */
    public function getCommentStatus()
    {
        return $this->comment_status;
    }

    /**
     * Set remote_addr
     *
     * @param string $remoteAddr
     */
    public function setRemoteAddr($remoteAddr)
    {
        $this->remote_addr = $remoteAddr;
    }

    /**
     * Get remote_addr
     *
     * @return string 
     */
    public function getRemoteAddr()
    {
        return $this->remote_addr;
    }

    /**
     * Set http_user_agent
     *
     * @param string $httpUserAgent
     */
    public function setHttpUserAgent($httpUserAgent)
    {
        $this->http_user_agent = $httpUserAgent;
    }

    /**
     * Get http_user_agent
     *
     * @return string 
     */
    public function getHttpUserAgent()
    {
        return $this->http_user_agent;
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
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set bike
     *
     * @param TwoKings\Bundle\EBikeBundle\Entity\Bike $bike
     */
    public function setBike(\TwoKings\Bundle\EBikeBundle\Entity\Bike $bike)
    {
        $this->bike = $bike;
    }

    /**
     * Get bike
     *
     * @return TwoKings\Bundle\EBikeBundle\Entity\Bike 
     */
    public function getBike()
    {
        return $this->bike;
    }
}
