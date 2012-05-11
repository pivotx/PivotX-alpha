<?php

namespace PivotX\Doctrine\Entity;


class GenerateEntity
{
    private $entity;
    private $metaclassdata;
    private $feature_configuration;

    private $property_classes;

    public function __construct($entity, $metaclassdata, $feature_configuration)
    {
        $this->entity                = $entity;
        $this->metaclassdata         = $metaclassdata;
        $this->feature_configuration = $feature_configuration;
        $this->property_classes      = array();
    }

    protected function getOneFields($entity)
    {
        $fields = array();

        foreach($this->metaclassdata->fieldMappings as $fieldname => $info) {
            if (!isset($info['id']) || ($info['id'] === false)) {
                $fields[] = $fieldname;
            }
        }

        /*
        // find the manytoone relations
        foreach($this->metaclassdata->associationMappings as $fieldname => $info) {
            if (!isset($info['id']) || ($info['id'] === false)) {
                $fields[] = $fieldname;
            }
        }
        */

        echo $entity.': '.implode(', ',$fields)."\n";
//        var_dump($this->metaclassdata);

        return $fields;

        switch ($entity) {
            case 'Entry':
                var_dump($this->metaclassdata);
                return array(
                    'resource_id',
                    'publicid',
                    'date_created',
                    'date_modified',
                    'viewable',
                    'publish_state',
                    'publish_on',
                    'depublish_on',
                    'version'
                );
                break;

            case 'EntryLanguage':
                return array(
                    'enabled',
                    'language',
                    'slug',
                    'title',
                    'entry'
                );
                break;
        }

        return array();
    }

    protected function getToManyFields($entity)
    {
        $fields = array();

        foreach($this->metaclassdata->associationMappings as $fieldname => $info) {
            if (!isset($info['id']) || ($info['id'] === false)) {
                $fields[] = $fieldname;
            }
        }

        return $fields;

        switch ($entity) {
            case 'Entry':
                return array(
                    'language'
                );
                break;
        }

        return array();
    }

    // @todo not used anymore
    protected function generateClassProperties()
    {
        $code = '';

        $one_fields = $this->getOneFields($this->entity);
        foreach($one_fields as $f) {
            $code .= "    protected \$".$f.";\n";
        }
        $code .= "\n";

        $tomany_fields = $this->getToManyFields($this->entity);
        foreach($tomany_fields as $f) {
            $g = $f.'s';
            $code .= "    protected \$".$g.";\n";
        }
        $code .= "\n";

        return $code;
    }

    protected function generateConstructor()
    {
        $code = '';

        $code .= "    public function __construct()\n";
        $code .= "    {\n";

        $tomany_fields = $this->getToManyFields($this->entity);
        foreach($tomany_fields as $f) {
            $g = $f.'s';
            $code .= "      \$this->$g = new \\Doctrine\\Common\\Collections\\ArrayCollection();\n";
        }

        $code .= "    }\n";
        $code .= "\n";

        return $code;
    }

    protected function generateClassPropertyMethods($methods)
    {
        $code = '';

        $one_fields = $this->getOneFields($this->entity);
        foreach($one_fields as $f) {
            $method_get = \Doctrine\Common\Util\Inflector::camelize('get_'.$f);
            $method_set = \Doctrine\Common\Util\Inflector::camelize('set_'.$f);
            $method_isn = \Doctrine\Common\Util\Inflector::camelize('is_null_'.$f);

            if (!in_array($method_get,$methods)) {
                $code .= "    public function $method_get()\n";
                $code .= "    {\n";
                $code .= "        return \$this->$f;\n";
                $code .= "    }\n";
                $code .= "\n";
            }
            if (!in_array($method_set,$methods)) {
                $code .= "    public function $method_set(\$value)\n";
                $code .= "    {\n";
                $code .= "        \$this->$f = \$value;\n";
                $code .= "        return \$this;\n";
                $code .= "    }\n";
                $code .= "\n";
            }
            // here?
            if (!in_array($method_isn,$methods)) {
                $code .= "    public function $method_isn()\n";
                $code .= "    {\n";
                $code .= "        return is_null(\$this->$f);\n";
                $code .= "    }\n";
                $code .= "\n";
            }
        }

        $tomany_fields = $this->getToManyFields($this->entity);
        foreach($tomany_fields as $f) {
            $g = $f.'s';
            $method_get = \Doctrine\Common\Util\Inflector::camelize('get_'.$g);
            $method_add = \Doctrine\Common\Util\Inflector::camelize('add_'.$f);

            if (!in_array($method_get,$methods)) {
                $code .= "    public function $method_get()\n";
                $code .= "    {\n";
                $code .= "        return \$this->$g;\n";
                $code .= "    }\n";
                $code .= "\n";
            }
            if (!in_array($method_add,$methods)) {
                $code .= "    public function $method_add(\$value)\n";
                $code .= "    {\n";
                $code .= "        \$this->$g"."[] = \$value;\n";
                $code .= "        return \$this;\n";
                $code .= "    }\n";
                $code .= "\n";
            }
        }

        return $code;
    }

    public function addPropertyClass($class)
    {
        if (class_exists($class)) {
            $this->property_classes[] = $class;
        }
    }

    public function generateCode()
    {
        $classname = $this->entity;

        $property_classes   = array();
        $property_classes[] = 'PivotX\\Doctrine\\Entity\\SharedProperty';

        $property_classes = array_merge($property_classes,$this->property_classes);


        $class_comment_classes = ' * '.implode("\n * ",$property_classes);


        $code = <<<THEEND
namespace PivotX\Doctrine\Entity;

THEEND;

        $code = <<<THEEND

/**
 * Property classes:
$class_comment_classes
 */
class $classname
{
    protected \$id;

THEEND;

        $code .= $this->generateClassProperties();
        $code .= $this->generateConstructor();

        $all_methods = array();

        foreach($property_classes as $pclass) {
            $pobject = new $pclass;

            $methods = $pobject->getPropertyMethods();
            foreach($methods as $name => $methodcall) {
                $args = array($this->entity);
                if (($pos = strpos($methodcall,':')) !== false) {
                    $method = substr($methodcall,0,$pos);
                    $argtxt = substr($methodcall,$pos+1);

                    $args = explode(',',$argtxt);
                    array_unshift($args,$this->entity);
                }
                else {
                    $method = $methodcall;
                }

            
                $code .= call_user_func_array(array($pobject,$method),$args)."\n";

                $all_methods[] = $name;
            }
        }

        $code .= $this->generateClassPropertyMethods($all_methods);

        $code .= <<<THEEND
}

THEEND;

        return $code;
    }
}

