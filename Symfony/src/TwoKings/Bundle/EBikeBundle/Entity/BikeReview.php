<?php

namespace TwoKings\Bundle\EBikeBundle\Entity;

/**
 */
class BikeReview extends \PivotX\Doctrine\Entity\AutoEntity
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
     * @var text $comment
     */
    private $comment;

    /**
     * @var TwoKings\Bundle\EBikeBundle\Entity\Bike
     */
    private $reviews;


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
}