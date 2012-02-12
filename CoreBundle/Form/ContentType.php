<?php

namespace PivotX\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ContentType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('slug', 'text')
            ->add('reference', 'text')
            ->add('grouping', 'text')
            ->add('title', 'text')
            ->add('teaser')
            ->add('body')
            ->add('template', 'text')
            ->add('dateCreated', 'datetime', array('widget' => 'single_text'))
            ->add('dateModified', 'datetime', array('widget' => 'single_text'))
            ->add('datePublished', 'datetime', array('widget' => 'single_text'))
            ->add('dateDepublished', 'datetime', array('widget' => 'single_text'))
            ->add('datePublishOn', 'datetime', array('widget' => 'single_text'))
            ->add('dateDepublishOn', 'datetime', array('widget' => 'single_text'))
            ->add('language', 'text')
            ->add('version')
            ->add('status', 'text')
            ->add('searchable')
            ->add('locked')
            ->add('originUrl', 'url')
            ->add('originCreator', 'text')
            ->add('textFormatting', 'text')
            ->add('allowResponses')
            ->add('contenttype')
            ->add('user')
        ;
    }

    public function getName()
    {
        return 'pivotx_corebundle_contenttype';
    }
}
