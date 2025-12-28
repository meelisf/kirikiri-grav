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

/* home.html.twig */
class __TwigTemplate_ad729113c2a5d1cce39df6659389e938 extends Template
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
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a->enter($__internal_2b03fcd95a85c4310cf548a70fb8bc2a_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "home.html.twig"));

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
        yield "    ";
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["uri"] ?? null), "param", ["tag"], "method", false, false, false, 4)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 5
            yield "        <h1 class=\"page-title text-center\">Teema: ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["uri"] ?? null), "param", ["tag"], "method", false, false, false, 5), "html", null, true);
            yield "</h1>
    ";
        }
        // line 7
        yield "    ";
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["uri"] ?? null), "param", ["author"], "method", false, false, false, 7)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 8
            yield "        <h1 class=\"page-title text-center\">Autor: ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["uri"] ?? null), "param", ["author"], "method", false, false, false, 8), "html", null, true);
            yield "</h1>
    ";
        }
        // line 10
        yield "
    <div class=\"post-grid\">
    ";
        // line 12
        $context["posts"] = CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "collection", [], "method", false, false, false, 12);
        // line 13
        yield "    ";
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["posts"] ?? null)) == 0)) {
            // line 14
            yield "        ";
            $context["posts"] = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "find", ["/blog"], "method", false, false, false, 14), "children", [], "method", false, false, false, 14), "order", ["date", "desc"], "method", false, false, false, 14), "slice", [0, 6], "method", false, false, false, 14);
            // line 15
            yield "    ";
        }
        // line 16
        yield "    ";
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["posts"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["post"]) {
            // line 17
            yield "            <article class=\"card\">
                ";
            // line 18
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["post"], "header", [], "any", false, false, false, 18), "image", [], "any", false, false, false, 18)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 19
                yield "                    <a href=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["post"], "url", [], "any", false, false, false, 19), "html", null, true);
                yield "\" class=\"card-image-link\">
                        <img src=\"";
                // line 20
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (($_v0 = CoreExtension::getAttribute($this->env, $this->source, $context["post"], "media", [], "any", false, false, false, 20)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0[CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["post"], "header", [], "any", false, false, false, 20), "image", [], "any", false, false, false, 20)] ?? null) : null), "url", [], "any", false, false, false, 20), "html", null, true);
                yield "\" alt=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["post"], "title", [], "any", false, false, false, 20), "html", null, true);
                yield "\" class=\"card-image\">
                    </a>
                ";
            }
            // line 23
            yield "                
                <div class=\"card-content\">
                    <div class=\"card-category\">
                        ";
            // line 26
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["post"], "taxonomy", [], "any", false, false, false, 26), "tag", [], "any", false, false, false, 26));
            $context['_iterated'] = false;
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
                // line 27
                yield "                            <a href=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["base_url"] ?? null), "html", null, true);
                yield "/tag:";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["tag"], "html", null, true);
                yield "\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["tag"], "html", null, true);
                yield "</a>";
                if ((($tmp =  !CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "last", [], "any", false, false, false, 27)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    yield ", ";
                }
                // line 28
                yield "                        ";
                $context['_iterated'] = true;
                ++$context['loop']['index0'];
                ++$context['loop']['index'];
                $context['loop']['first'] = false;
                if (isset($context['loop']['revindex0'], $context['loop']['revindex'])) {
                    --$context['loop']['revindex0'];
                    --$context['loop']['revindex'];
                    $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                }
            }
            if (!$context['_iterated']) {
                // line 29
                yield "                            Uudised
                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['tag'], $context['_parent'], $context['_iterated'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 31
            yield "                    </div>
                    <h3 class=\"card-title\">
                        <a href=\"";
            // line 33
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["post"], "url", [], "any", false, false, false, 33), "html", null, true);
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["post"], "title", [], "any", false, false, false, 33), "html", null, true);
            yield "</a>
                    </h3>
                    <div class=\"card-excerpt\">
                        ";
            // line 36
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::striptags(CoreExtension::getAttribute($this->env, $this->source, $context["post"], "summary", [], "any", false, false, false, 36)), "html", null, true);
            yield "
                    </div>
                    <div class=\"card-footer\">
                        ";
            // line 39
            $context["months"] = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
            // line 40
            yield "                        <span class=\"card-date\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["post"], "date", [], "any", false, false, false, 40), "j."), "html", null, true);
            yield " ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v1 = ($context["months"] ?? null)) && is_array($_v1) || $_v1 instanceof ArrayAccess ? ($_v1[($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["post"], "date", [], "any", false, false, false, 40), "n") - 1)] ?? null) : null), "html", null, true);
            yield " ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["post"], "date", [], "any", false, false, false, 40), "Y"), "html", null, true);
            yield "</span>
                        ";
            // line 41
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["post"], "header", [], "any", false, false, false, 41), "author", [], "any", false, false, false, 41)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 42
                yield "                            <span class=\"card-author\">
                                <a href=\"";
                // line 43
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["base_url"] ?? null), "html", null, true);
                yield "/author:";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::urlencode(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["post"], "header", [], "any", false, false, false, 43), "author", [], "any", false, false, false, 43)), "html", null, true);
                yield "\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["post"], "header", [], "any", false, false, false, 43), "author", [], "any", false, false, false, 43), "html", null, true);
                yield "</a>
                            </span>
                        ";
            }
            // line 46
            yield "                    </div>
                </div>
            </article>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['post'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 50
        yield "    </div>
";
        
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a->leave($__internal_2b03fcd95a85c4310cf548a70fb8bc2a_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "home.html.twig";
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
        return array (  230 => 50,  221 => 46,  211 => 43,  208 => 42,  206 => 41,  197 => 40,  195 => 39,  189 => 36,  181 => 33,  177 => 31,  170 => 29,  157 => 28,  146 => 27,  128 => 26,  123 => 23,  115 => 20,  110 => 19,  108 => 18,  105 => 17,  100 => 16,  97 => 15,  94 => 14,  91 => 13,  89 => 12,  85 => 10,  79 => 8,  76 => 7,  70 => 5,  67 => 4,  57 => 3,  40 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'partials/base.html.twig' %}

{% block content %}
    {% if uri.param('tag') %}
        <h1 class=\"page-title text-center\">Teema: {{ uri.param('tag') }}</h1>
    {% endif %}
    {% if uri.param('author') %}
        <h1 class=\"page-title text-center\">Autor: {{ uri.param('author') }}</h1>
    {% endif %}

    <div class=\"post-grid\">
    {% set posts = page.collection() %}
    {% if posts|length == 0 %}
        {% set posts = page.find('/blog').children().order('date', 'desc').slice(0, 6) %}
    {% endif %}
    {% for post in posts %}
            <article class=\"card\">
                {% if post.header.image %}
                    <a href=\"{{ post.url }}\" class=\"card-image-link\">
                        <img src=\"{{ post.media[post.header.image].url }}\" alt=\"{{ post.title }}\" class=\"card-image\">
                    </a>
                {% endif %}
                
                <div class=\"card-content\">
                    <div class=\"card-category\">
                        {% for tag in post.taxonomy.tag %}
                            <a href=\"{{ base_url }}/tag:{{ tag }}\">{{ tag }}</a>{% if not loop.last %}, {% endif %}
                        {% else %}
                            Uudised
                        {% endfor %}
                    </div>
                    <h3 class=\"card-title\">
                        <a href=\"{{ post.url }}\">{{ post.title }}</a>
                    </h3>
                    <div class=\"card-excerpt\">
                        {{ post.summary|striptags }}
                    </div>
                    <div class=\"card-footer\">
                        {% set months = [\"jaanuar\", \"veebruar\", \"märts\", \"aprill\", \"mai\", \"juuni\", \"juuli\", \"august\", \"september\", \"oktoober\", \"november\", \"detsember\"] %}
                        <span class=\"card-date\">{{ post.date|date(\"j.\") }} {{ months[post.date|date(\"n\") - 1] }} {{ post.date|date(\"Y\") }}</span>
                        {% if post.header.author %}
                            <span class=\"card-author\">
                                <a href=\"{{ base_url }}/author:{{ post.header.author|url_encode }}\">{{ post.header.author }}</a>
                            </span>
                        {% endif %}
                    </div>
                </div>
            </article>
        {% endfor %}
    </div>
{% endblock %}
", "home.html.twig", "/var/www/html/user/themes/kirikiri/templates/home.html.twig");
    }
}
