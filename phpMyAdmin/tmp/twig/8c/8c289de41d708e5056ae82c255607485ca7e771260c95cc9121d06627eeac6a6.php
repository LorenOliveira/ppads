<?php

/* select_all.twig */
class __TwigTemplate_4ef3cacc24275b2a4029e800d561da1cce600f17d66bf531a914f546cc208431 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        echo "<img class=\"selectallarrow\" src=\"";
        echo twig_escape_filter($this->env, (isset($context["pma_theme_image"]) ? $context["pma_theme_image"] : null), "html", null, true);
        echo "arrow_";
        echo twig_escape_filter($this->env, (isset($context["text_dir"]) ? $context["text_dir"] : null), "html", null, true);
        echo ".png\"
    width=\"38\" height=\"22\" alt=\"";
        // line 2
        echo _gettext("With selected:");
        echo "\" />
<input type=\"checkbox\" id=\"";
        // line 3
        echo twig_escape_filter($this->env, (isset($context["form_name"]) ? $context["form_name"] : null), "html", null, true);
        echo "_checkall\" class=\"checkall_box\"
    title=\"";
        // line 4
        echo _gettext("Check all");
        echo "\" />
<label for=\"";
        // line 5
        echo twig_escape_filter($this->env, (isset($context["form_name"]) ? $context["form_name"] : null), "html", null, true);
        echo "_checkall\">";
        echo _gettext("Check all");
        echo "</label>
<i style=\"margin-left: 2em\">";
        // line 6
        echo _gettext("With selected:");
        echo "</i>
";
    }

    public function getTemplateName()
    {
        return "select_all.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  44 => 6,  38 => 5,  34 => 4,  30 => 3,  26 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "select_all.twig", "C:\\xampp\\phpMyAdmin\\templates\\select_all.twig");
    }
}
