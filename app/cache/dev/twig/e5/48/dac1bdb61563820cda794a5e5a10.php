<?php

/* IgaOAuthBundle:Default:index.html.twig */
class __TwigTemplate_e548dac1bdb61563820cda794a5e5a10 extends Twig_Template
{
    protected function doDisplay(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        // line 1
        echo "Hello ";
        echo twig_escape_filter($this->env, $this->getContext($context, 'name'), "html");
        echo "!
";
    }

    public function getTemplateName()
    {
        return "IgaOAuthBundle:Default:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
