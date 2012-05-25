<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\Component\Twigquery;

/**
 * Twig Loadall experiment
 *
 * @author Marcel Wouters <marcel@twokings.nl>
 *
 * @api
 */
class Loadall extends \Twig_TokenParser
{
    public function parse(\Twig_Token $token)
    {
        $lineno = $token->getLine();

        //*
        $name = $this->parser->getStream()->expect(\Twig_Token::NAME_TYPE)->getValue();
        //$this->parser->getStream()->expect(\Twig_Token::OPERATOR_TYPE, '=');
        //$value = $this->parser->getExpressionParser()->parseExpression();

        $this->parser->getStream()->expect(\Twig_Token::BLOCK_END_TYPE);
        //*/

        return new Loadallnode($name, $lineno, $this->getTag());
    }

    public function getTag()
    {
        return 'loadAll';
    }
}
