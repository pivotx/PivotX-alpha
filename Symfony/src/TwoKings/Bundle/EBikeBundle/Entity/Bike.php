<?php

namespace TwoKings\Bundle\EBikeBundle\Entity;

/**
 */
//class Bike extends \PivotX\Doctrine\Entity\AutoEntity
class Bike 
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $publicid
     */
    private $publicid;

    /**
     * @var datetime $date_created
     */
    private $date_created;

    /**
     * @var datetime $date_modified
     */
    private $date_modified;

    /**
     * @var boolean $viewable
     */
    private $viewable;

    /**
     * @var string $publish_state
     */
    private $publish_state;

    /**
     * @var datetime $publish_on
     */
    private $publish_on;

    /**
     * @var datetime $depublish_on
     */
    private $depublish_on;

    /**
     * @var string $title
     */
    private $title;

    /**
     * @var boolean $available
     */
    private $available;

    /**
     * @var integer $price
     */
    private $price;

    /**
     * @var integer $weight
     */
    private $weight;

    /**
     * @var integer $weight_battery
     */
    private $weight_battery;

    /**
     * @var integer $year_built
     */
    private $year_built;

    /**
     * @var integer $range_min
     */
    private $range_min;

    /**
     * @var integer $range_avg
     */
    private $range_avg;

    /**
     * @var integer $range_max
     */
    private $range_max;

    /**
     * @var integer $battery_voltage
     */
    private $battery_voltage;

    /**
     * @var integer $battery_amps
     */
    private $battery_amps;

    /**
     * @var string $engine_location
     */
    private $engine_location;

    /**
     * @var string $image_file
     */
    private $image_file;

    /**
     * @var string $brochure_file
     */
    private $brochure_file;

    /**
     * @var string $product_uri;
     */
    private $product_uri;

    /**
     * @var text $info;
     */
    private $info;

    /**
     * @var TwoKings\Bundle\EBikeBundle\Entity\BikeReview
     */
    private $reviews;

    /**
     * @var TwoKings\Bundle\EBikeBundle\Entity\Brand
     */
    private $brand;

    public function __construct()
    {
        $this->reviews = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set publicid
     *
     * @param string $publicid
     */
    public function setPublicid($publicid)
    {
        $this->publicid = $publicid;
    }

    /**
     * Get publicid
     *
     * @return string 
     */
    public function getPublicid()
    {
        return $this->publicid;
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
     * Set publish_state
     *
     * @param string $publishState
     */
    public function setPublishState($publishState)
    {
        $this->publish_state = $publishState;
    }

    /**
     * Get publish_state
     *
     * @return string 
     */
    public function getPublishState()
    {
        return $this->publish_state;
    }

    /**
     * Set publish_on
     *
     * @param datetime $publishOn
     */
    public function setPublishOn($publishOn)
    {
        $this->publish_on = $publishOn;
    }

    /**
     * Get publish_on
     *
     * @return datetime 
     */
    public function getPublishOn()
    {
        return $this->publish_on;
    }

    /**
     * Set depublish_on
     *
     * @param datetime $depublishOn
     */
    public function setDepublishOn($depublishOn)
    {
        $this->depublish_on = $depublishOn;
    }

    /**
     * Get depublish_on
     *
     * @return datetime 
     */
    public function getDepublishOn()
    {
        return $this->depublish_on;
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Add reviews
     *
     * @param TwoKings\Bundle\EBikeBundle\Entity\BikeReview $reviews
     */
    public function addBikeReview(\TwoKings\Bundle\EBikeBundle\Entity\BikeReview $reviews)
    {
        $this->reviews[] = $reviews;
    }

    /**
     * Get reviews
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    /**
     * Set brand
     *
     * @param TwoKings\Bundle\EBikeBundle\Entity\Brand $brand
     */
    public function setBrand(\TwoKings\Bundle\EBikeBundle\Entity\Brand $brand)
    {
        $this->brand = $brand;
    }

    /**
     * Get brand
     *
     * @return TwoKings\Bundle\EBikeBundle\Entity\Brand 
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set available
     *
     * @param boolean $available
     */
    public function setAvailable($available)
    {
        $this->available = $available;
    }

    /**
     * Get available
     *
     * @return boolean 
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * Set price
     *
     * @param integer $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set weight
     *
     * @param integer $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    /**
     * Get weight
     *
     * @return integer 
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set weight_battery
     *
     * @param integer $weightBattery
     */
    public function setWeightBattery($weightBattery)
    {
        $this->weight_battery = $weightBattery;
    }

    /**
     * Get weight_battery
     *
     * @return integer 
     */
    public function getWeightBattery()
    {
        return $this->weight_battery;
    }

    /**
     * Set range_min
     *
     * @param integer $rangeMin
     */
    public function setRangeMin($rangeMin)
    {
        $this->range_min = $rangeMin;
    }

    /**
     * Get range_min
     *
     * @return integer 
     */
    public function getRangeMin()
    {
        return $this->range_min;
    }

    /**
     * Set range_avg
     *
     * @param integer $rangeAvg
     */
    public function setRangeAvg($rangeAvg)
    {
        $this->range_avg = $rangeAvg;
    }

    /**
     * Get range_avg
     *
     * @return integer 
     */
    public function getRangeAvg()
    {
        return $this->range_avg;
    }

    /**
     * Set range_max
     *
     * @param integer $rangeMax
     */
    public function setRangeMax($rangeMax)
    {
        $this->range_max = $rangeMax;
    }

    /**
     * Get range_max
     *
     * @return integer 
     */
    public function getRangeMax()
    {
        return $this->range_max;
    }

    /**
     * Set battery_voltage
     *
     * @param integer $batteryVoltage
     */
    public function setBatteryVoltage($batteryVoltage)
    {
        $this->battery_voltage = $batteryVoltage;
    }

    /**
     * Get battery_voltage
     *
     * @return integer 
     */
    public function getBatteryVoltage()
    {
        return $this->battery_voltage;
    }

    /**
     * Set battery_amps
     *
     * @param integer $batteryAmps
     */
    public function setBatteryAmps($batteryAmps)
    {
        $this->battery_amps = $batteryAmps;
    }

    /**
     * Get battery_amps
     *
     * @return integer 
     */
    public function getBatteryAmps()
    {
        return $this->battery_amps;
    }

    /**
     * Set engine_location
     *
     * @param string $engineLocation
     */
    public function setEngineLocation($engineLocation)
    {
        $this->engine_location = $engineLocation;
    }

    /**
     * Get engine_location
     *
     * @return string 
     */
    public function getEngineLocation()
    {
        return $this->engine_location;
    }

    /**
     * Set image_file
     *
     * @param string $imageFile
     */
    public function setImageFile($imageFile)
    {
        $this->image_file = $imageFile;
    }

    /**
     * Get image_file
     *
     * @return string 
     */
    public function getImageFile()
    {
        return $this->image_file;
    }

    /**
     * Set brochure_file
     *
     * @param string $brochureFile
     */
    public function setBrochureFile($brochureFile)
    {
        $this->brochure_file = $brochureFile;
    }

    /**
     * Get brochure_file
     *
     * @return string 
     */
    public function getBrochureFile()
    {
        return $this->brochure_file;
    }

    /**
     * Set product_uri
     *
     * @param string $productUri
     */
    public function setProductUri($productUri)
    {
        $this->product_uri = $productUri;
    }

    /**
     * Get product_uri
     *
     * @return string 
     */
    public function getProductUri()
    {
        return $this->product_uri;
    }

    /**
     * Set info
     *
     * @param text $info
     */
    public function setInfo($info)
    {
        $this->info = $info;
    }

    /**
     * Get info
     *
     * @return text 
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Set year_built
     *
     * @param integer $yearBuilt
     */
    public function setYearBuilt($yearBuilt)
    {
        $this->year_built = $yearBuilt;
    }

    /**
     * Get year_built
     *
     * @return integer 
     */
    public function getYearBuilt()
    {
        return $this->year_built;
    }
}
