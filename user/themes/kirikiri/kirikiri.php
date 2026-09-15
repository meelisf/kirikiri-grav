<?php
namespace Grav\Theme;

use Grav\Common\Theme;

class Kirikiri extends Theme
{
    public static function getSubscribedEvents()
    {
        return [
            'onPageContentRaw' => ['onPageContentRaw', 0],
            'onAdminPageTypes' => ['onAdminPageTypes', 0]
        ];
    }

    public function onPageContentRaw(\RocketTheme\Toolbox\Event\Event $event)
    {
        $page = $event['page'];
        $raw = $page->getRawContent();

        // Regulaaravaldis Markdown piltide leidmiseks: ![alt](url "title")
        // Leiab: 1=alt, 2=url, 3=title (valikuline)
        $newContent = preg_replace_callback('/!\[(.*?)\]\((.*?)(\s+".*?")?\)/', function ($matches) {
            $alt = $matches[1];
            $url = $matches[2];
            $title = isset($matches[3]) ? $matches[3] : '';

            // Kontrollime, kas on väline link (http/https) -> ei puutu
            if (preg_match('/^https?:\/\//', $url)) {
                return $matches[0];
            }

            // Kontrollime faililaiendit (ainult pildid, mida tahame töödelda)
            // Kasutame 'i' lippu case-insensitive
            if (preg_match('/\.(jpg|jpeg|png)$/i', $url)) {
                
                // Kontrollime, kas URL-il on juba parameetreid (?)
                $separator = (strpos($url, '?') !== false) ? '&' : '?';
                
                // Kui user pole juba ise width või resize'i määranud
                if (strpos($url, 'width=') === false && strpos($url, 'resize=') === false) {
                    $url .= $separator . 'width=800';
                    $separator = '&'; // Järgmise jaoks kindlasti &
                }

                // Lisame webp, kui pole juba määratud
                if (strpos($url, 'derivative=') === false) {
                    $url .= $separator . 'derivative=webp';
                }
            }

            return "![$alt]($url$title)";
        }, $raw);

        $page->setRawContent($newContent);
    }

    /**
     * Admini mallivaliku sildid tulevad Gravis PALJALT FAILINIMEST:
     * Types::pageSelect() teeb `ucfirst(str_replace('_', ' ', $name))` ja
     * blueprinti `title:` sinna ei jõua kunagi. Seetõttu seisis rippmenüüs
     * "Default" ka siis, kui blueprinti pealkiri oli juba "Artikkel".
     *
     * api BlueprintController::filterPageTypes() laseb selle nimekirja läbi
     * sündmusest `onAdminPageTypes` (sama leping, mis klassikalisel adminil),
     * nii et siin saab sildid eestikeelseks kirjutada. Ainult SILDID —
     * mallide võtmed jäävad puutumata, sest sama nimekiri toidab ka
     * redigeerimisvormi mallivalikut.
     *
     * `default` tõstetakse ette ka seepärast, et admin2 tagavaraloogika
     * (nodes/19: `V.find(t => t.type === "default") ?? V[0]`) langeks
     * halvimal juhul samuti artikli peale.
     */
    public function onAdminPageTypes(\RocketTheme\Toolbox\Event\Event $event)
    {
        $labels = [
            'default'  => 'Artikkel',
            'item'     => 'Artikkel (vana mall)',
            'page'     => 'Lihtleht',
            'home'     => 'Avaleht',
            'archives' => 'Artiklite koond',
            'tags'     => 'Siltide koond',
            'authors'  => 'Autorite koond',
            'blog'     => 'Blogi koond',
            'taxonomy' => 'Taksonoomia koond',
        ];

        $types = (array) $event['types'];

        foreach ($labels as $type => $label) {
            if (array_key_exists($type, $types)) {
                $types[$type] = $label;
            }
        }

        if (array_key_exists('default', $types)) {
            $types = ['default' => $types['default']] + $types;
        }

        $event['types'] = $types;
    }

    public static function getCurrentDate()
    {
        return date('d-m-Y H:i');
    }
}
