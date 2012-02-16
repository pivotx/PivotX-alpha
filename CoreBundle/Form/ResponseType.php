<?php

namespace PivotX\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ResponseType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('reference', 'text', array('required' => false))
            ->add('responseType', 'text')
            ->add('title', 'text', array('required' => false))
            ->add('body')
            ->add('name', 'text')
            ->add('email', 'text', array('required' => false))
            ->add('url', 'text', array('required' => false))
            ->add('ip', 'text', array('required' => false))
            ->add('dateCreated', 'datetime', array('widget' => 'single_text'))
            ->add('status', 'text', array('required' => false))
            ->add('originUrl', 'text', array('required' => false))
            ->add('originCreator', 'text', array('required' => false))
            ->add('content', 'entity', array('class' => 'PivotXCoreBundle:Content', "required" => false ))
            ->add('user', 'entity', array('class' => 'PivotXCoreBundle:User', "required" => false ))
        ;
    }

    public function getName()
    {
        return 'pivotx_corebundle_responsetype';
    }
}
