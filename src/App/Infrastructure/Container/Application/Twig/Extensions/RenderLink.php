<?php
/**
 * @file
 * Contains App\Twig\Extensions\ElementError.
 */

namespace App\Infrastructure\Container\Application\Twig\Extensions;

class RenderLink extends \Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('renderLink', [$this, 'renderLink']),
        ];
    }

    public function renderLink(string $text)
    {
        if (!empty($text)) {
            $string = strip_tags($text);

            $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
            $string = preg_replace($url, '<a href="http$2://$4" target="_blank" title="$0"><strong>$0</strong></a>', $string);

            $text = nl2br($string);
        }

        return $text;
    }
}
