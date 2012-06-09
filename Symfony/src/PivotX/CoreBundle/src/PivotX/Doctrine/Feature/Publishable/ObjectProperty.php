<?php

namespace PivotX\Doctrine\Feature\Publishable;


class ObjectProperty implements \PivotX\Doctrine\Entity\EntityProperty
{
    private $field_publish_date = 'publish_on';
    private $field_depublish_date = 'depublish_on';
    private $field_publish_state = 'publish_state';

    public function __construct()
    {
    }

    public function getPropertyMethods()
    {
        return array(
            'evaluateViewable' => 'generateEvaluateViewable',
            'getCrudIgnore_'.$this->field_publish_date => 'generateGetCrudIgnorePublishDate',
            'getCrudIgnore_'.$this->field_depublish_date => 'generateGetCrudIgnoreDePublishDate',
            //'getCrudType_'.$this->field_publish_state => 'generateGetCrudType',
            'getCrudChoices_'.$this->field_publish_state => 'generateGetCrudChoices',
            'isPublished' => 'generateIsPublished',
            'setPublishState' => 'generateSetPublishState',
            'getPublishState' => 'generateGetPublishState',
            'setPublishDateTime' => 'generateSetPublishDateTime',
            'setDepublishDateTime' => 'generateSetDepublishDateTime'
        );
    }

    public function generateEvaluateViewable($entity)
    {
        return <<<THEEND
    /**
     * Returns true if entity is viewable (within the context of this property)
     */
    public function evaluateViewable()
    {
        \$viewable = false;

//        switch (\$this->$this->field_publish_state) {
        switch (\$this->getPublishState()) {
            case 'published':
                \$viewable = true;
                break;
            case 'depublished':
                \$viewable = false;
                break;
            case 'timed-publish':
                \$viewable = false;
                break;
            case 'timed-depublish':
                \$viewable = true;
                break;
        }

        return \$viewable;
    }

THEEND;
    }

    public function generateGetCrudIgnorePublishDate()
    {
        $field = $this->field_publish_date;
        return <<<THEEND
    /**
     */
    public function getCrudIgnore_$field()
    {
        return true;
    }
THEEND;
    }

    public function generateGetCrudIgnoreDePublishDate()
    {
        $field = $this->field_depublish_date;
        return <<<THEEND
    /**
     */
    public function getCrudIgnore_$field()
    {
        return true;
    }
THEEND;
    }

    public function generateGetCrudChoices()
    {
        $statefield = $this->field_publish_state;
        return <<<THEEND
    /**
     * Return all the CRUD choices
     *
     * @return array Array of choices
     */
    public function getCrudChoices_$statefield()
    {
        return array(
            'published',
            'depublished'

            // these two are not options you should be able to select here
            // 'timed-publish',
            // 'timed-depublish'
        );
    }
THEEND;
    }

    public function generateIsPublished($entity)
    {
        return <<<THEEND
    public function isPublished()
    {
        return in_array(\$this->getPublishState(), array('published', 'timed-depublish'));
    }

THEEND;
    }

    public function generateGetPublishState($entity)
    {
        return <<<THEEND
    public function getPublishState()
    {
        return \$this->$this->field_publish_state;
    }

THEEND;
    }

    public function generateSetPublishState($entity)
    {
        return <<<THEEND
    public function setPublishState(\$state)
    {
        \$this->$this->field_publish_state = \$state;
        return \$this;
    }

THEEND;
    }

    public function generateSetPublishDateTime($entity)
    {
        return <<<THEEND
    public function setPublishDateTime(\$datetime, \$update_state = true)
    {
        \$this->$this->field_publish_date = \$datetime;
        if (\$update_state) {
            \$this->$this->field_publish_state = 'timed-publish';
        }
        return \$this;
    }

THEEND;
    }

    public function generateSetDepublishDateTime($entity)
    {
        return <<<THEEND
    public function setDepublishDateTime(\$datetime, \$update_state = true)
    {
        \$this->$this->field_depublish_date = \$datetime;
        if (\$update_state) {
            \$this->$this->field_publish_state = 'timed-depublish';
        }
        return \$this;
    }

THEEND;
    }
}

