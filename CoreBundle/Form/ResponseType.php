<?php

namespace PivotX\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ResponseType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('reference', 'text')
            ->add('responseType', 'text')
            ->add('title', 'text')
            ->add('body')
            ->add('name', 'text')
            ->add('email', 'text')
            ->add('url', 'text')
            ->add('ip', 'text')
            ->add('dateCreated', 'datetime', array('widget' => 'single_text'))
            ->add('status', 'text')
            ->add('originUrl', 'text')
            ->add('originCreator', 'text')
            ->add('content', 'choice', array('required'=>false))
            ->add('user', 'entity', array('class' => 'PivotXCoreBundle:User', "required" => false ))
        ;
    }

    public function getName()
    {
        return 'pivotx_corebundle_responsetype';
    }
}
