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

/* partials/base.html.twig */
class __TwigTemplate_3d8b09ed865e36a21742c78524d63e3c extends Template
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
            'head' => [$this, 'block_head'],
            'stylesheets' => [$this, 'block_stylesheets'],
            'header' => [$this, 'block_header'],
            'content' => [$this, 'block_content'],
            'footer' => [$this, 'block_footer'],
            'javascripts' => [$this, 'block_javascripts'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a = $this->extensions["Twig\\Extension\\ProfilerExtension"];
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a->enter($__internal_2b03fcd95a85c4310cf548a70fb8bc2a_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "partials/base.html.twig"));

        // line 1
        yield "<!DOCTYPE html>
<html lang=\"";
        // line 2
        yield ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["grav"] ?? null), "language", [], "any", false, false, false, 2), "getActive", [], "any", false, false, false, 2)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["grav"] ?? null), "language", [], "any", false, false, false, 2), "getActive", [], "any", false, false, false, 2), "html", null, true)) : ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["grav"] ?? null), "config", [], "any", false, false, false, 2), "site", [], "any", false, false, false, 2), "default_lang", [], "any", false, false, false, 2), "html", null, true)));
        yield "\">
<head>
";
        // line 4
        yield from $this->unwrap()->yieldBlock('head', $context, $blocks);
        // line 20
        yield "</head>
<body class=\"";
        // line 21
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "header", [], "any", false, false, false, 21), "body_class", [], "any", false, false, false, 21), "html", null, true);
        yield "\">
    ";
        // line 22
        yield from $this->unwrap()->yieldBlock('header', $context, $blocks);
        // line 25
        yield "
    <main id=\"main-content\">
        <div class=\"container\">
            ";
        // line 28
        yield from $this->unwrap()->yieldBlock('content', $context, $blocks);
        // line 29
        yield "        </div>
    </main>

    ";
        // line 32
        yield from $this->unwrap()->yieldBlock('footer', $context, $blocks);
        // line 35
        yield "
    ";
        // line 36
        yield from $this->unwrap()->yieldBlock('javascripts', $context, $blocks);
        // line 59
        yield "    ";
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["assets"] ?? null), "js", [], "method", false, false, false, 59);
        yield "
</body>
</html>
";
        
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a->leave($__internal_2b03fcd95a85c4310cf548a70fb8bc2a_prof);

        yield from [];
    }

    // line 4
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_head(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a = $this->extensions["Twig\\Extension\\ProfilerExtension"];
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a->enter($__internal_2b03fcd95a85c4310cf548a70fb8bc2a_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "head"));

        // line 5
        yield "    <meta charset=\"utf-8\" />
    <title>";
        // line 6
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["header"] ?? null), "title", [], "any", false, false, false, 6)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["header"] ?? null), "title", [], "any", false, false, false, 6));
            yield " | ";
        }
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["site"] ?? null), "title", [], "any", false, false, false, 6));
        yield "</title>
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\" />
    
    ";
        // line 10
        yield from $this->load("partials/metadata.html.twig", 10)->unwrap()->yield($context);
        // line 11
        yield "
    <link rel=\"icon\" type=\"image/png\" href=\"";
        // line 12
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Grav\Common\Twig\Extension\GravExtension']->urlFunc("theme://images/favicon.png"), "html", null, true);
        yield "\" />
    <link rel=\"canonical\" href=\"";
        // line 13
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "url", [true, true], "method", false, false, false, 13), "html", null, true);
        yield "\" />

    ";
        // line 15
        yield from $this->unwrap()->yieldBlock('stylesheets', $context, $blocks);
        // line 18
        yield "    ";
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["assets"] ?? null), "css", [], "method", false, false, false, 18);
        yield "
";
        
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a->leave($__internal_2b03fcd95a85c4310cf548a70fb8bc2a_prof);

        yield from [];
    }

    // line 15
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_stylesheets(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a = $this->extensions["Twig\\Extension\\ProfilerExtension"];
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a->enter($__internal_2b03fcd95a85c4310cf548a70fb8bc2a_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "stylesheets"));

        // line 16
        yield "        ";
        CoreExtension::getAttribute($this->env, $this->source, ($context["assets"] ?? null), "addCss", ["theme://css/custom.css", 100], "method", false, false, false, 16);
        // line 17
        yield "    ";
        
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a->leave($__internal_2b03fcd95a85c4310cf548a70fb8bc2a_prof);

        yield from [];
    }

    // line 22
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_header(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a = $this->extensions["Twig\\Extension\\ProfilerExtension"];
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a->enter($__internal_2b03fcd95a85c4310cf548a70fb8bc2a_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "header"));

        // line 23
        yield "        ";
        yield from $this->load("partials/header.html.twig", 23)->unwrap()->yield($context);
        // line 24
        yield "    ";
        
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a->leave($__internal_2b03fcd95a85c4310cf548a70fb8bc2a_prof);

        yield from [];
    }

    // line 28
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a = $this->extensions["Twig\\Extension\\ProfilerExtension"];
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a->enter($__internal_2b03fcd95a85c4310cf548a70fb8bc2a_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "content"));

        
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a->leave($__internal_2b03fcd95a85c4310cf548a70fb8bc2a_prof);

        yield from [];
    }

    // line 32
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_footer(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a = $this->extensions["Twig\\Extension\\ProfilerExtension"];
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a->enter($__internal_2b03fcd95a85c4310cf548a70fb8bc2a_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        // line 33
        yield "        ";
        yield from $this->load("partials/footer.html.twig", 33)->unwrap()->yield($context);
        // line 34
        yield "    ";
        
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a->leave($__internal_2b03fcd95a85c4310cf548a70fb8bc2a_prof);

        yield from [];
    }

    // line 36
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_javascripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a = $this->extensions["Twig\\Extension\\ProfilerExtension"];
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a->enter($__internal_2b03fcd95a85c4310cf548a70fb8bc2a_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "javascripts"));

        // line 37
        yield "        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Auto-convert images with titles to figures
                var images = document.querySelectorAll('.content img[title]');
                images.forEach(function(img) {
                    var title = img.getAttribute('title');
                    if (title) {
                        var figure = document.createElement('figure');
                        var caption = document.createElement('figcaption');
                        caption.textContent = title;
                        
                        // Insert figure after img
                        img.parentNode.insertBefore(figure, img);
                        // Move img into figure
                        figure.appendChild(img);
                        // Append caption
                        figure.appendChild(caption);
                    }
                });
            });
        </script>
    ";
        
        $__internal_2b03fcd95a85c4310cf548a70fb8bc2a->leave($__internal_2b03fcd95a85c4310cf548a70fb8bc2a_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "partials/base.html.twig";
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
        return array (  242 => 37,  232 => 36,  224 => 34,  221 => 33,  211 => 32,  195 => 28,  187 => 24,  184 => 23,  174 => 22,  166 => 17,  163 => 16,  153 => 15,  142 => 18,  140 => 15,  135 => 13,  131 => 12,  128 => 11,  126 => 10,  115 => 6,  112 => 5,  102 => 4,  89 => 59,  87 => 36,  84 => 35,  82 => 32,  77 => 29,  75 => 28,  70 => 25,  68 => 22,  64 => 21,  61 => 20,  59 => 4,  54 => 2,  51 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!DOCTYPE html>
<html lang=\"{{ grav.language.getActive ?: grav.config.site.default_lang }}\">
<head>
{% block head %}
    <meta charset=\"utf-8\" />
    <title>{% if header.title %}{{ header.title|e }} | {% endif %}{{ site.title|e }}</title>
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\" />
    
    {% include 'partials/metadata.html.twig' %}

    <link rel=\"icon\" type=\"image/png\" href=\"{{ url('theme://images/favicon.png') }}\" />
    <link rel=\"canonical\" href=\"{{ page.url(true, true) }}\" />

    {% block stylesheets %}
        {% do assets.addCss('theme://css/custom.css', 100) %}
    {% endblock %}
    {{ assets.css() | raw }}
{% endblock %}
</head>
<body class=\"{{ page.header.body_class }}\">
    {% block header %}
        {% include 'partials/header.html.twig' %}
    {% endblock %}

    <main id=\"main-content\">
        <div class=\"container\">
            {% block content %}{% endblock %}
        </div>
    </main>

    {% block footer %}
        {% include 'partials/footer.html.twig' %}
    {% endblock %}

    {% block javascripts %}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Auto-convert images with titles to figures
                var images = document.querySelectorAll('.content img[title]');
                images.forEach(function(img) {
                    var title = img.getAttribute('title');
                    if (title) {
                        var figure = document.createElement('figure');
                        var caption = document.createElement('figcaption');
                        caption.textContent = title;
                        
                        // Insert figure after img
                        img.parentNode.insertBefore(figure, img);
                        // Move img into figure
                        figure.appendChild(img);
                        // Append caption
                        figure.appendChild(caption);
                    }
                });
            });
        </script>
    {% endblock %}
    {{ assets.js() | raw }}
</body>
</html>
", "partials/base.html.twig", "/var/www/html/user/themes/kirikiri/templates/partials/base.html.twig");
    }
}
