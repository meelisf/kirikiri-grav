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

/* partials/header.html.twig */
class __TwigTemplate_6b5309f9c6f22cac01cbb409c2099f3d extends Template
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
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a->enter($__internal_2b03fcd95a85c4310cf548a70fb8bc2a_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "partials/header.html.twig"));

        // line 1
        yield "<header class=\"site-header\">
  <div class=\"container\">
    <div class=\"masthead\">
      <a href=\"";
        // line 4
        yield (((($context["base_url"] ?? null) == "")) ? ("/") : ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["base_url"] ?? null), "html", null, true)));
        yield "\" class=\"masthead-logo\">
        <img src=\"";
        // line 5
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Grav\Common\Twig\Extension\GravExtension']->urlFunc("theme://images/kirikiri.png"), "html", null, true);
        yield "\" alt=\"";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["site"] ?? null), "title", [], "any", false, false, false, 5), "html", null, true);
        yield "\">
      </a>
      <div class=\"site-tagline\">
        ";
        // line 8
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["site"] ?? null), "metadata", [], "any", false, false, false, 8), "description", [], "any", false, false, false, 8), "html", null, true);
        yield "
      </div>
    </div>

    <nav class=\"nav-main\">
      ";
        // line 13
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["pages"] ?? null), "children", [], "any", false, false, false, 13), "visible", [], "any", false, false, false, 13));
        foreach ($context['_seq'] as $context["_key"] => $context["page"]) {
            // line 14
            yield "        ";
            $context["current_page"] = (((CoreExtension::getAttribute($this->env, $this->source, $context["page"], "active", [], "any", false, false, false, 14) || CoreExtension::getAttribute($this->env, $this->source, $context["page"], "activeChild", [], "any", false, false, false, 14))) ? ("active") : (""));
            // line 15
            yield "        <a href=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["page"], "url", [], "any", false, false, false, 15), "html", null, true);
            yield "\" class=\"nav-link ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["current_page"] ?? null), "html", null, true);
            yield "\">
          ";
            // line 16
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["page"], "menu", [], "any", false, false, false, 16), "html", null, true);
            yield "
        </a>
      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['page'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 19
        yield "    </nav>
  </div>
</header>
";
        
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a->leave($__internal_2b03fcd95a85c4310cf548a70fb8bc2a_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "partials/header.html.twig";
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
        return array (  93 => 19,  84 => 16,  77 => 15,  74 => 14,  70 => 13,  62 => 8,  54 => 5,  50 => 4,  45 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<header class=\"site-header\">
  <div class=\"container\">
    <div class=\"masthead\">
      <a href=\"{{ base_url == '' ? '/' : base_url }}\" class=\"masthead-logo\">
        <img src=\"{{ url('theme://images/kirikiri.png') }}\" alt=\"{{ site.title }}\">
      </a>
      <div class=\"site-tagline\">
        {{ site.metadata.description }}
      </div>
    </div>

    <nav class=\"nav-main\">
      {% for page in pages.children.visible %}
        {% set current_page = (page.active or page.activeChild) ? 'active' : '' %}
        <a href=\"{{ page.url }}\" class=\"nav-link {{ current_page }}\">
          {{ page.menu }}
        </a>
      {% endfor %}
    </nav>
  </div>
</header>
", "partials/header.html.twig", "/var/www/html/user/themes/kirikiri/templates/partials/header.html.twig");
    }
}
