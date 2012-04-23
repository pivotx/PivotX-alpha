<?php

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Parameter;

/*
$container->setDefinition(
    'pivot_x_core.example',
    new Definition(
        'PivotX\CoreBundle\Example',
        array(
            new Reference('service_id'),
            "plain_value",
            new Parameter('parameter_name'),
        )
    )
);
*/

/*
$definition = new Definition('Acme\HelloBundle\Extension\FooExtension');
$definition->addTag('twig.extension');
$container->setDefinition('foo.twig.extension', $definition);
*/

// @todo clean this
//echo 'Services in CoreBundle'."\n";
$definition = new Definition('PivotX\Doctrine\Extension\Definition');
$definition->addTag('kernel.cache_warmer');
$container->setDefinition('pivotx.kernel.cache_warmer', $definition);
