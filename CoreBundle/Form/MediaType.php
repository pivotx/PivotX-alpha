<?php

namespace PivotX\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('slug', 'text', array('required' => false))
            ->add('date', 'datetime', array('widget' => 'single_text'))
            ->add('reference', 'text', array('required' => false))
            ->add('filename', 'text')
            ->add('filepath', 'text')
            ->add('width')
            ->add('height')
            ->add('filesize')
            ->add('originUrl', 'text', array('required' => false))
            ->add('originCreator', 'text', array('required' => false))
            ->add('user', 'entity', array('class' => 'PivotXCoreBundle:User', "required" => false ))
        ;
    }

    public function getName()
    {
        return 'pivotx_corebundle_mediatype';
    }
}
