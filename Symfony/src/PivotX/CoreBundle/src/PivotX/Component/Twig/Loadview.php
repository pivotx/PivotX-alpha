<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Component\Twig;

/**
 * Twig PivotX Loadview
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 *
 * @api
 */
class Loadview extends \Twig_TokenParser
{
    public function parse(\Twig_Token $token)
    {
        $lineno = $token->getLine();
        $arguments = array();

        $viewexpr = $this->parser->getExpressionParser()->parseExpression();
        if ($viewexpr->hasAttribute('value')) {
            $view = $viewexpr->getAttribute('value');
        }
        else if ($viewexpr->hasAttribute('name')) {
            // @todo make this work
            //$name = $viewexpr->getAttribute('name');
        }
        $name = preg_replace('|[^a-z0-9]+|','_',$view);

        $asexpr = null;
        if ($this->parser->getStream()->test(\Twig_Token::NAME_TYPE, 'as')) {
            $this->parser->getStream()->next();
            $asexpr = $this->parser->getExpressionParser()->parseExpression();

            $name = $asexpr->getAttribute('name');
        }

        //echo '<pre>'; var_dump($name); var_dump($view); echo '</pre>';

        $this->parser->getStream()->expect(\Twig_Token::BLOCK_END_TYPE);

        return new Loadviewnode($name, $view, $arguments, $lineno, $this->getTag());
    }

    public function getTag()
    {
        return 'loadView';
    }
}
