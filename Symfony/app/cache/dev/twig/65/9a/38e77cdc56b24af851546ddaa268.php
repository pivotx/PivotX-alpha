<?php

/* PivotXCoreBundle:Default:index.html.twig */
class __TwigTemplate_659a38e77cdc56b24af851546ddaa268 extends Twig_Template
{
    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"";
        // line 2
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "html"), "language"), "html", null, true);
        echo "\">
    <head>
        <meta charset=\"";
        // line 4
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getContext($context, "html"), "meta"), "charset"), "html", null, true);
        echo "\">
        <title>";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "html"), "title"), "html", null, true);
        echo "</title>
    </head>

    <body>

    </body>

</html>
";
    }

    public function getTemplateName()
    {
        return "PivotXCoreBundle:Default:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
