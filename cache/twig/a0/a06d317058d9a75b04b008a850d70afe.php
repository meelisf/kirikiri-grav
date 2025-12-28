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

/* item.html.twig */
class __TwigTemplate_4bdc25abeedf9e287ac86ccb636a21ca extends Template
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

        $this->blocks = [
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 1
        return "partials/base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a = $this->extensions["Twig\\Extension\\ProfilerExtension"];
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a->enter($__internal_2b03fcd95a85c4310cf548a70fb8bc2a_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "item.html.twig"));

        $this->parent = $this->load("partials/base.html.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
        
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a->leave($__internal_2b03fcd95a85c4310cf548a70fb8bc2a_prof);

    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a = $this->extensions["Twig\\Extension\\ProfilerExtension"];
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a->enter($__internal_2b03fcd95a85c4310cf548a70fb8bc2a_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "content"));

        // line 4
        yield "    <article class=\"post-detail\">
        <header class=\"article-hero card ";
        // line 5
        if ((($tmp =  !CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "header", [], "any", false, false, false, 5), "image", [], "any", false, false, false, 5)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "no-image";
        }
        yield "\">
            <div class=\"article-hero-text\">
                <div class=\"article-category\">
                    ";
        // line 8
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "taxonomy", [], "any", false, false, false, 8), "tag", [], "any", false, false, false, 8));
        $context['loop'] = [
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        ];
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["tag"]) {
            // line 9
            yield "                        <a href=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["base_url"] ?? null), "html", null, true);
            yield "/tag:";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["tag"], "html", null, true);
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["tag"], "html", null, true);
            yield "</a>";
            if ((($tmp =  !CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "last", [], "any", false, false, false, 9)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                yield ", ";
            }
            // line 10
            yield "                    ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['revindex0'], $context['loop']['revindex'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['tag'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 11
        yield "                </div>
                <h1 class=\"article-title\">";
        // line 12
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "title", [], "any", false, false, false, 12), "html", null, true);
        yield "</h1>
                <div class=\"article-meta\">
                    ";
        // line 14
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "header", [], "any", false, false, false, 14), "author", [], "any", false, false, false, 14)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 15
            yield "                        <div class=\"article-author\">
                            <a href=\"";
            // line 16
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["base_url"] ?? null), "html", null, true);
            yield "/author:";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::urlencode(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "header", [], "any", false, false, false, 16), "author", [], "any", false, false, false, 16)), "html", null, true);
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "header", [], "any", false, false, false, 16), "author", [], "any", false, false, false, 16), "html", null, true);
            yield "</a>
                        </div>
                    ";
        }
        // line 19
        yield "                    ";
        $context["months"] = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
        // line 20
        yield "                    <div class=\"article-date\">";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "date", [], "any", false, false, false, 20), "j."), "html", null, true);
        yield " ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v0 = ($context["months"] ?? null)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0[($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "date", [], "any", false, false, false, 20), "n") - 1)] ?? null) : null), "html", null, true);
        yield " ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "date", [], "any", false, false, false, 20), "Y"), "html", null, true);
        yield "</div>
                </div>
            </div>
            ";
        // line 23
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "header", [], "any", false, false, false, 23), "image", [], "any", false, false, false, 23)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 24
            yield "                <div class=\"article-hero-image\">
                    <img src=\"";
            // line 25
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (($_v1 = CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "media", [], "any", false, false, false, 25)) && is_array($_v1) || $_v1 instanceof ArrayAccess ? ($_v1[CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "header", [], "any", false, false, false, 25), "image", [], "any", false, false, false, 25)] ?? null) : null), "url", [], "any", false, false, false, 25), "html", null, true);
            yield "\" alt=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "title", [], "any", false, false, false, 25), "html", null, true);
            yield "\">
                </div>
            ";
        }
        // line 28
        yield "        </header>

        <div class=\"article-content content\">
            ";
        // line 31
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, false, 31);
        yield "
        </div>
    </article>
";
        
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a->leave($__internal_2b03fcd95a85c4310cf548a70fb8bc2a_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "item.html.twig";
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
        return array (  175 => 31,  170 => 28,  162 => 25,  159 => 24,  157 => 23,  146 => 20,  143 => 19,  133 => 16,  130 => 15,  128 => 14,  123 => 12,  120 => 11,  106 => 10,  95 => 9,  78 => 8,  70 => 5,  67 => 4,  57 => 3,  40 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'partials/base.html.twig' %}

{% block content %}
    <article class=\"post-detail\">
        <header class=\"article-hero card {% if not page.header.image %}no-image{% endif %}\">
            <div class=\"article-hero-text\">
                <div class=\"article-category\">
                    {% for tag in page.taxonomy.tag %}
                        <a href=\"{{ base_url }}/tag:{{ tag }}\">{{ tag }}</a>{% if not loop.last %}, {% endif %}
                    {% endfor %}
                </div>
                <h1 class=\"article-title\">{{ page.title }}</h1>
                <div class=\"article-meta\">
                    {% if page.header.author %}
                        <div class=\"article-author\">
                            <a href=\"{{ base_url }}/author:{{ page.header.author|url_encode }}\">{{ page.header.author }}</a>
                        </div>
                    {% endif %}
                    {% set months = [\"jaanuar\", \"veebruar\", \"märts\", \"aprill\", \"mai\", \"juuni\", \"juuli\", \"august\", \"september\", \"oktoober\", \"november\", \"detsember\"] %}
                    <div class=\"article-date\">{{ page.date|date(\"j.\") }} {{ months[page.date|date(\"n\") - 1] }} {{ page.date|date(\"Y\") }}</div>
                </div>
            </div>
            {% if page.header.image %}
                <div class=\"article-hero-image\">
                    <img src=\"{{ page.media[page.header.image].url }}\" alt=\"{{ page.title }}\">
                </div>
            {% endif %}
        </header>

        <div class=\"article-content content\">
            {{ page.content|raw }}
        </div>
    </article>
{% endblock %}
", "item.html.twig", "/var/www/html/user/themes/kirikiri/templates/item.html.twig");
    }
}
