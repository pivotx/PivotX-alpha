<?php

namespace PivotX\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('slug', 'text')
            ->add('date', 'datetime', array('widget' => 'single_text'))
            ->add('reference', 'text')
            ->add('filename', 'text')
            ->add('filepath', 'text')
            ->add('width')
            ->add('height')
            ->add('filesize')
            ->add('originUrl', 'text')
            ->add('originCreator', 'text')
            ->add('user')
        ;
    }

    public function getName()
    {
        return 'pivotx_corebundle_mediatype';
    }
}
