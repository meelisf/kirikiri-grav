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

/* partials/metadata.html.twig */
class __TwigTemplate_e6eed070d2014b25087952067f6c8657 extends Template
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
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a->enter($__internal_2b03fcd95a85c4310cf548a70fb8bc2a_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "partials/metadata.html.twig"));

        // line 1
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "metadata", [], "any", false, false, false, 1));
        foreach ($context['_seq'] as $context["_key"] => $context["meta"]) {
            // line 2
            yield "    <meta ";
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["meta"], "name", [], "any", false, false, false, 2)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                yield "name=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["meta"], "name", [], "any", false, false, false, 2));
                yield "\" ";
            }
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["meta"], "http_equiv", [], "any", false, false, false, 2)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                yield "http-equiv=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["meta"], "http_equiv", [], "any", false, false, false, 2));
                yield "\" ";
            }
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["meta"], "charset", [], "any", false, false, false, 2)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                yield "charset=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["meta"], "charset", [], "any", false, false, false, 2));
                yield "\" ";
            }
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["meta"], "property", [], "any", false, false, false, 2)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                yield "property=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["meta"], "property", [], "any", false, false, false, 2));
                yield "\" ";
            }
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["meta"], "content", [], "any", false, false, false, 2)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                yield "content=\"";
                yield CoreExtension::getAttribute($this->env, $this->source, $context["meta"], "content", [], "any", false, false, false, 2);
                yield "\" ";
            }
            yield "/>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['meta'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a->leave($__internal_2b03fcd95a85c4310cf548a70fb8bc2a_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "partials/metadata.html.twig";
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
        return array (  49 => 2,  45 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% for meta in page.metadata %}
    <meta {% if meta.name %}name=\"{{ meta.name|e }}\" {% endif %}{% if meta.http_equiv %}http-equiv=\"{{ meta.http_equiv|e }}\" {% endif %}{% if meta.charset %}charset=\"{{ meta.charset|e }}\" {% endif %}{% if meta.property %}property=\"{{ meta.property|e }}\" {% endif %}{% if meta.content %}content=\"{{ meta.content|raw }}\" {% endif %}/>
{% endfor %}
", "partials/metadata.html.twig", "/var/www/html/system/templates/partials/metadata.html.twig");
    }
}
