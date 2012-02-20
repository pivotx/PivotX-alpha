<?php


class pxobject
{
    protected $type;
    protected $data_core = array();
    protected $data_shared = array();

    public function __call($name,$args)
    {
        // look through registered aspects for type
        // if found
            $aspect = new $registeredaspectclass($this);
            call_user_func_array($aspect,$args);
    }
}

class pxstorage
{
    public static function _modifyLoadArgs($args);

    public static function _superLoad($args)
    {
        // call all _modifyLoadArgs from registered aspects

        // do the actual load

        // loop results
            // call _loadObject($this) for each registered aspect
    }

    public static function loadOne($id)
    {
        return self::loadBy($primarykeyfield,$id);
    }

    public static function loadOneBy($field,$value)
    {
        $args = array(
            $field => $value
        );
        $results = self::loadMultiple($args);
        return $results[0];
    }

    public static function loadMultiple($args)
    {
        return self::_superLoad($args);
    }

    public function save($object)
    {
        // call all from registered aspects _saveObject('before',$object)
        // save to storage
        // call all from registered aspects _saveObject('after',$object)
    }

    public function delete($object)
    {
        // call all from registered aspects _deleteObject('before',$object)
        // delete from storage
        // call all from registered aspects _deleteObject('after',$object)
    }
}

class pxaspect
{
    protected $object; // (reference)

    public function __construct($object)
    {
        $this->object = $object;
    }

    public function _loadObject($moment,$object);
    public function _saveObject($moment,$object);
    public function _deleteObject($moment,$object);
}


/**
 * @SCT\Entity
 * @SCT\Aspect(name="publishable")
 * @SCT\Aspect(name="versionable")
 * @SCT\Aspect(name="record")
 * @SCT\Aspect(name="extrafields")
 * @SCT\Aspect(name="publicid")
 * @SCT\Aspect(name="multilingual")
 */
class Entry extends pxobject
{
    /**
     * @var integer $id
     *
     * @SCT\Column(name="id", type="integer")
     * @SCT\Id
     * @SCT\GeneratedValue(strategy="AUTO")
     */
    private $id;
}



/**
 * Following aspect definitions go elsewhere
 */


/**
 * Makes an object publishable
 *
 * This aspect adds fields:
 * - status
 * - publish_date
 * - depublish_date
 */
class publishable_aspect extends pxaspect
{
    public function publishNow();
    public function unpublishNow();
    public function publishOn($datetime);
    public function unpublishOn($datetime);
}

class publishable_storage extends pxstorage
{
    public static function _modifyLoadArgs($args)
    {
        // by default load only 'published' articles
        return $args;
    }

    /**
     * @SCT\Filter(type="DefaultFront")
     */
    public static function filterPublished();

    /**
     * @SCT\Filter(type="DefaultBack")
     */
    public static function filterAll();

    /**
     * @SCT\Filter
     */
    public static function filterUnpublished();
}

/**
 * Makes an object record
 *
 * This aspect adds fields:
 * - date_creation
 * - date_edited
 */
class record_aspect extends pxaspect
{
    public function _saveObject()
    {
        // update date edited/creation
    }
}

class record_storage extends pxstorage
{
    /**
     * @SCT\Filter(type="DefaultFront")
     */
    public static filterNormal();
    public static filterRecent($args);
}

/**
 * Makes an object multilingual
 *
 * This aspects adds fields:
 * (none)
 */
class extrafields_aspect extends pxaspect
{
}

class extrafields_storage extends pxstorage
{
    public static function _modifyLoadArgs($args)
    {
        // join in extrafields
        return $args;
    }

    /**
     * @SCT\Filter(type="DefaultFront")
     */
    public static filterNormal()
}

/**
 */
class versionable_aspect extends pxaspect
{
    public function saveAsDraft();
}

class versionable_storage extends pxstorage
{
    public static function _modifyLoadArgs($args)
    {
        // by default load only committed versions
        return $args;
    }

    /**
     * @SCT\Filter(type="DefaultFront")
     */
    public static function filterHead();

    /**
     * @SCT\Filter
     */
    public static function filterDrafted();

    /**
     * @SCT\Filter
     */
    public static function filterVersion($version);
}


/**
 * Makes an object have a publicid
 *
 * This aspects add fields
 * - publicid
 */
class publicid_aspect extends pxaspect
{
}


/**
 * Makes an object multilingual
 *
 * Requires aspect publicid
 *
 * This aspects adds fields:
 * - languages
 */
class multilingual_aspect extends pxaspect
{
}

class multilingual_storage extends pxstorage
{
    public static function _modifyLoadArgs($args)
    {
        // by default load current language
        return $args;
    }

    /**
     * @SCT\Filter(type="DefaultFront")
     */
    public static function filterLanguage($language=null);

    /**
     * @SCT\Filter(type="DefaultBack")
     */
    public static function filterAnyLanguage();
}



/*
pxregistry::registerObjectAspect('entry','publishable');
pxregistry::registerObjectAspect('entry','versionable');
pxregistry::registerObjectAspect('entry','record');
pxregistry::registerObjectAspect('entry','extrafields');
pxregistry::registerObjectAspect('entry','publicid');
pxregistry::registerObjectAspect('entry','multilingual');
*/


$o = pxfactory::create('entry');

$o->publishOn('2012-04-01 08:00');
$o->depublishNow();


$entries = pxfactory::loadMultiple();
$entry   = pxfactory::loadRecentlyPublished();
$dutch   = pxfactory::loadOne(array('id'=>5,'language'=>'nl'));

$entityManager->find('CMS\Article', 1234)

?>
