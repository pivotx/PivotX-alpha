<?php

namespace PivotX\Doctrine\Entity;


class GenerateEntity
{
    private $entity;
    private $entity_class;
    private $metaclassdata;
    private $feature_configuration;

    private $property_classes;

    public function __construct($entity, $metaclassdata, $feature_configuration)
    {
        $this->entity                = $entity;
        $this->metaclassdata         = $metaclassdata;
        $this->feature_configuration = $feature_configuration;
        $this->property_classes      = array();

        $this->entity_class = $metaclassdata->reflClass->name;
    }

    protected function getOneFields($entity)
    {
        $fields = array();

        foreach($this->metaclassdata->fieldMappings as $fieldname => $info) {
            if (!isset($info['id']) || ($info['id'] === false)) {
                $fields[$fieldname] = $info;
;
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

        //echo $entity.': '.implode(', ',$fields)."\n";
        //var_dump($this->metaclassdata);

        return $fields;
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
    }

    public function getPluralText($singular)
    {
        switch (substr($singular,-1)) {
            case 'y':
                return substr($singular,0,-1).'ies';
                break;

            case 's':
                return $singular.'es';
                break;
        }

        return $singular.'s';
    }

    public function getSingularText($plural)
    {
        if (substr($plural,-3) == 'ies') {
            return substr($plural,0,-3).'y';
        }

        if (substr($plural,-2) == 'es') {
            return substr($plural,0,-2);
        }

        if (substr($plural,-1) == 's') {
            return substr($plural,0,-1);
        }

        return $plural;
    }

    protected function generateClassProperties()
    {
        $code = '';
        
        $code .= "    /"."**\n";
        $code .= "     * Reference to original object\n";
        $code .= "     *"."/\n";
        $code .= "    protected \$shared_reference = null;\n";
        $code .= "\n";

        return $code;
    }

    protected function generateConstructor()
    {
        $code = '';

        $code .= "    /"."**\n";
        $code .= "     * Construct our auto-entity object\n";
        $code .= "     *"."/\n";
        $code .= "    public function __construct(\$reference)\n";
        $code .= "    {\n";
        $code .= "        \$this->shared_reference = \$reference;\n";
        $code .= "    }\n";
        $code .= "\n";

        return $code;
    }

    protected function generateGetId()
    {
        $code = '';

        $code .= "    public function getId()\n";
        $code .= "    {\n";
        $code .= "        try {\n";
        $code .= "            \$reflectionProperty = new \\ReflectionProperty(\$this->shared_reference, 'id');\n";
        $code .= "            \$reflectionProperty->setAccessible(true);\n";
        $code .= "            return \$reflectionProperty->getValue(\$this->shared_reference);\n";
        $code .= "        }\n";
        $code .= "        catch (Exception \$e) {\n";
        $code .= "            // do nothing atm\n";
        $code .= "        }\n";
        $code .= "        return null;\n";
        $code .= "    }\n";

        $code .= "\n";

        return $code;
    }

    protected function generateClassPropertyMethods($methods)
    {
        $code = '';

        $one_fields = $this->getOneFields($this->entity);
        foreach($one_fields as $f => $info) {
            $method_get = \Doctrine\Common\Util\Inflector::camelize('get_'.$f);
            $method_set = \Doctrine\Common\Util\Inflector::camelize('set_'.$f);
            $method_isn = \Doctrine\Common\Util\Inflector::camelize('is_null_'.$f);

            if ((!in_array($method_get,$methods)) && (!method_exists($this->entity_class,$method_get))) {
                $code .= "    public function $method_get()\n";
                $code .= "    {\n";
                $code .= "        try {\n";
                $code .= "            \$reflectionProperty = new \\ReflectionProperty(\$this->shared_reference, '$f');\n";
                $code .= "            \$reflectionProperty->setAccessible(true);\n";
                $code .= "            return \$reflectionProperty->getValue(\$this->shared_reference);\n";
                $code .= "        }\n";
                $code .= "        catch (Exception \$e) {\n";
                $code .= "            // do nothing atm\n";
                $code .= "        }\n";
                $code .= "        return null;\n";
                $code .= "    }\n";
                $code .= "\n";
            }
            if ((!in_array($method_set,$methods)) && (!method_exists($this->entity_class,$method_set))) {
                $code .= "    public function $method_set(\$value)\n";
                $code .= "    {\n";
                $code .= "        try {\n";
                $code .= "            \$reflectionProperty = new \\ReflectionProperty(\$this->shared_reference, '$f');\n";
                $code .= "            \$reflectionProperty->setAccessible(true);\n";
                $code .= "            \$reflectionProperty->setValue(\$this->shared_reference,\$value);\n";
                $code .= "        }\n";
                $code .= "        catch (Exception \$e) {\n";
                $code .= "            // do nothing atm\n";
                $code .= "        }\n";
                $code .= "        return \$this;\n";
                $code .= "    }\n";
                $code .= "\n";
            }
            if ((!in_array($method_isn,$methods)) && (!method_exists($this->entity_class,$method_isn)) && ($info['nullable'] === true)) {
                $code .= "    public function $method_isn()\n";
                $code .= "    {\n";
                $code .= "        try {\n";
                $code .= "            \$reflectionProperty = new \\ReflectionProperty(\$this->shared_reference, '$f');\n";
                $code .= "            \$reflectionProperty->setAccessible(true);\n";
                $code .= "            \$value = \$reflectionProperty->getValue(\$this->shared_reference);\n";
                $code .= "            return is_null(\$value);\n";
                $code .= "        }\n";
                $code .= "        catch (Exception \$e) {\n";
                $code .= "            // do nothing atm\n";
                $code .= "        }\n";
                $code .= "        return true;\n";
                $code .= "    }\n";
                $code .= "\n";
            }
        }

        $tomany_fields = $this->getToManyFields($this->entity);
        foreach($tomany_fields as $f) {
            $g = $this->getPluralText($f);
            $h = $this->getSingularText($f);

            $method_get = \Doctrine\Common\Util\Inflector::camelize('get_'.$g);
            $method_add = \Doctrine\Common\Util\Inflector::camelize('add_'.$h);

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

    protected function generateSourceCall()
    {
        $code = '';

        $code .= <<<THEEND
    /**
     * Method call to original object
     */
    public function __call(\$name, \$args)
    {
        if (method_exists(\$this->shared_reference, \$name)) {
            switch (count(\$args)) {
                case 0:
                    return call_user_func(array(\$this->shared_reference,\$name));
                    break;
                case 1:
                    return call_user_func(array(\$this->shared_reference,\$name),\$args[0]);
                    break;
                case 2:
                    return call_user_func(array(\$this->shared_reference,\$name),\$args[0],\$args[1]);
                    break;
                case 3:
                    return call_user_func(array(\$this->shared_reference,\$name),\$args[0],\$args[1],\$args[2]);
                    break;
                case 4:
                    return call_user_func(array(\$this->shared_reference,\$name),\$args[0],\$args[1],\$args[2],\$args[3]);
                    break;
                case 5:
                    return call_user_func(array(\$this->shared_reference,\$name),\$args[0],\$args[1],\$args[2],\$args[3],\$args[4]);
                    break;
                case 6:
                    return call_user_func(array(\$this->shared_reference,\$name),\$args[0],\$args[1],\$args[2],\$args[3],\$args[4],\$args[5]);
                    break;
                case 7:
                    return call_user_func(array(\$this->shared_reference,\$name),\$args[0],\$args[1],\$args[2],\$args[3],\$args[4],\$args[5],\$args[6]);
                    break;

                default:
                    return call_user_func_array(array(\$this->shared_reference,\$name),\$args);
                    break;
            }
        }
        // do nothing atm
        return null;
    }


THEEND;
    /*
        $code .= "    /"."**\n";
        $code .= "     * Method call to original object\n";
        $code .= "     *"."/\n";
        $code .= "    public function __call(\$name, \$args)\n";
        $code .= "    {\n";
        $code .= "        if (method_exists(\$this->shared_reference,\$name)) {\n";
        // we should also make a big switch to directly call the method with various
        // amounts of arguments, because this is much faster
        $code .= "            return call_user_func_array(array(\$this->shared_reference,\$name),\$args);\n";
        $code .= "        }\n";
        $code .= "        // do nothing atm\n";
        $code .= "        return null;\n";
        $code .= "    }\n";
        $code .= "\n";
    */

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
        //$property_classes[] = 'PivotX\\Doctrine\\Entity\\SharedProperty';

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

THEEND;

        $code .= $this->generateClassProperties();
        $code .= $this->generateConstructor();
        $code .= $this->generateGetId();

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

        $code .= $this->generateSourceCall();

        $code .= <<<THEEND
}

THEEND;

        return $code;
    }
}

