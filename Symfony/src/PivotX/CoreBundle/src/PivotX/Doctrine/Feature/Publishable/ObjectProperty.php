<?php

namespace PivotX\Doctrine\Feature\Publishable;


class ObjectProperty implements \PivotX\Doctrine\Entity\EntityProperty
{
    private $field_publish_date = 'publish_date';
    private $field_depublish_date = 'publish_undate';
    private $field_publish_state = 'publish_state';

    public function __construct()
    {
    }

    public function getPropertyMethods()
    {
        return array(
            'evaluateViewable' => 'generateEvaluateViewable',
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

        switch (\$this->$this->field_publish_state) {
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

