<?php

/* SensioDistributionBundle:Configurator/Step:secret.html.twig */
class __TwigTemplate_4e9d753c971809ddf112c1292912a735 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "SensioDistributionBundle::Configurator/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        echo "Symfony - Configure global Secret";
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "    ";
        echo $this->env->getExtension('form')->setTheme($this->getContext($context, "form"), array("SensioDistributionBundle::Configurator/form.html.twig", ));
        // line 7
        echo "    ";
        $this->env->loadTemplate("SensioDistributionBundle::Configurator/steps.html.twig")->display(array_merge($context, array("index" => $this->getContext($context, "index"), "count" => $this->getContext($context, "count"))));
        // line 8
        echo "
    <h1>Global Secret</h1>
    <p>Configure the global secret for your website (the secret is used for the CSRF protection among other things):</p>

    ";
        // line 12
        echo $this->env->getExtension('form')->renderErrors($this->getContext($context, "form"));
        echo "
    <form action=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("_configurator_step", array("index" => $this->getContext($context, "index"))), "html", null, true);
        echo " \" method=\"POST\">
        <div class=\"symfony-form-row\">
            ";
        // line 15
        echo $this->env->getExtension('form')->renderLabel($this->getAttribute($this->getContext($context, "form"), "secret"));
        echo "
            <div class=\"symfony-form-field\">
                ";
        // line 17
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getContext($context, "form"), "secret"));
        echo "
                <a class=\"symfony-button-grey\" href=\"#\" onclick=\"generateSecret(); return false;\">Generate</a>
                <div class=\"symfony-form-errors\">
                    ";
        // line 20
        echo $this->env->getExtension('form')->renderErrors($this->getAttribute($this->getContext($context, "form"), "secret"));
        echo "
                </div>
            </div>
        </div>

        ";
        // line 25
        echo $this->env->getExtension('form')->renderRest($this->getContext($context, "form"));
        echo "

        <div class=\"symfony-form-footer\">
            <p><input type=\"submit\" value=\"Next Step\" class=\"symfony-button-grey\" /></p>
            <p>* mandatory fields</p>
        </div>

    </form>

    <script type=\"text/javascript\">
        function generateSecret()
        {
            var result = '';
            for (i=0; i < 32; i++) {
                result += Math.round(Math.random()*16).toString(16);
            }
            document.getElementById('distributionbundle_secret_step_secret').value = result;
        }
    </script>
";
    }

    public function getTemplateName()
    {
        return "SensioDistributionBundle:Configurator/Step:secret.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
