<?php

namespace PivotX\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ContentType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('slug', 'text', array("required" => false))
            ->add('reference', 'text', array("read_only" => true))
            ->add('grouping', 'text')
            ->add('title', 'text')
            ->add('teaser')
            ->add('body', 'textarea', array("required" => false))
            ->add('template', 'text', array("required" => false))
            ->add('dateCreated', 'datetime', array('widget' => 'single_text'))
            ->add('dateModified', 'datetime', array('widget' => 'single_text'))
            ->add('datePublished', 'datetime', array('widget' => 'single_text',  "required" => false))
            ->add('dateDepublished', 'datetime', array('widget' => 'single_text',  "required" => false))
            ->add('datePublishOn', 'datetime', array('widget' => 'single_text',  "required" => false))
            ->add('dateDepublishOn', 'datetime', array('widget' => 'single_text',  "required" => false))
            ->add('language', 'text', array("required" => false))
            ->add('version', 'integer', array("read_only" => true))
            ->add('status', 'text')
            ->add('searchable', 'checkbox', array("required" => false))
            ->add('locked', 'checkbox', array("required" => false))
            ->add('originUrl', 'url', array("required" => false))
            ->add('originCreator', 'text', array("required" => false))
            ->add('textFormatting', 'text')
            ->add('allowResponses', 'checkbox', array("required" => false))
            ->add('contenttype', 'entity', array('class' => 'PivotXCoreBundle:ContentType', "required" => false ))
            ->add('user', 'entity', array('class' => 'PivotXCoreBundle:User', "required" => false ))

        ;
    }

    public function getName()
    {
        return 'pivotx_corebundle_contenttype';
    }
}
