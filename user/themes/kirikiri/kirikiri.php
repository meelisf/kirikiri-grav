<?php
namespace Grav\Theme;

use Grav\Common\Theme;

class Kirikiri extends Theme
{
    public static function getSubscribedEvents()
    {
        return [
            'onPageContentRaw' => ['onPageContentRaw', 0]
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

    public static function getCurrentDate()
    {
        return date('d-m-Y H:i');
    }
}
