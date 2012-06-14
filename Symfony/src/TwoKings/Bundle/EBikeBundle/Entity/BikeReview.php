<?php

namespace TwoKings\Bundle\EBikeBundle\Entity;

use Symfony\Component\Validator\Constraints\MinLength;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Mapping\ClassMetadata;

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
     * @var integer $rating
     */
    private $rating;

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
     * Set rating
     *
     * @param text $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * Get rating
     *
     * @return text 
     */
    public function getRating()
    {
        return $this->rating;
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

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new NotBlank(array(
            'message' => 'U moet een naam invoeren'
        )));
        $metadata->addPropertyConstraint('name', new MinLength(array(
            'limit' => 2,
            'message' => 'Uw naam moet tenminste 2 karakters bevatten.'
        )));
        $metadata->addPropertyConstraint('email', new NotBlank(array(
            'message' => 'U moet een e-mailadres invoeren'
        )));
        $metadata->addPropertyConstraint('email', new Email(array(
            'message' => 'U moet hier een e-mailadres invoeren.',
        )));
        $metadata->addPropertyConstraint('rating', new NotBlank(array(
            'message' => 'U moet een beoordeling invoeren'
        )));
        $metadata->addPropertyConstraint('comment', new NotBlank(array(
            'message' => 'U moet een opmerking invoeren'
        )));
        $metadata->addPropertyConstraint('comment', new MinLength(array(
            'limit' => 20,
            'message' => 'U moet tenminste 20 karakters invoeren.'
        )));
    }
}
