<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* partials/footer.html.twig */
class __TwigTemplate_924273a628fe316d12ac33cc9a8d9d97 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a = $this->extensions["Twig\\Extension\\ProfilerExtension"];
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a->enter($__internal_2b03fcd95a85c4310cf548a70fb8bc2a_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "partials/footer.html.twig"));

        // line 1
        yield "<footer class=\"site-footer\">
  <div class=\"container\">
    <div class=\"footer-logo\">
       <a href=\"";
        // line 4
        yield (((($context["base_url"] ?? null) == "")) ? ("/") : ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["base_url"] ?? null), "html", null, true)));
        yield "\">
        <img src=\"";
        // line 5
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Grav\Common\Twig\Extension\GravExtension']->urlFunc("theme://images/kirikiri.png"), "html", null, true);
        yield "\" alt=\"";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["site"] ?? null), "title", [], "any", false, false, false, 5), "html", null, true);
        yield "\">
      </a>
    </div>
    <div class=\"copyright\">
      &copy; ";
        // line 9
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate("now", "Y"), "html", null, true);
        yield " ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["site"] ?? null), "title", [], "any", false, false, false, 9), "html", null, true);
        yield ". Kõik õigused kaitstud.
    </div>
  </div>
</footer>
";
        
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a->leave($__internal_2b03fcd95a85c4310cf548a70fb8bc2a_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "partials/footer.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  63 => 9,  54 => 5,  50 => 4,  45 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<footer class=\"site-footer\">
  <div class=\"container\">
    <div class=\"footer-logo\">
       <a href=\"{{ base_url == '' ? '/' : base_url }}\">
        <img src=\"{{ url('theme://images/kirikiri.png') }}\" alt=\"{{ site.title }}\">
      </a>
    </div>
    <div class=\"copyright\">
      &copy; {{ \"now\"|date(\"Y\") }} {{ site.title }}. Kõik õigused kaitstud.
    </div>
  </div>
</footer>
", "partials/footer.html.twig", "/var/www/html/user/themes/kirikiri/templates/partials/footer.html.twig");
    }
}
