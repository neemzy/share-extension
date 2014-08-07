<?php

namespace ShareExtension;

class ShareExtension extends \Twig_Extension
{
    /**
     * Twig extension name
     *
     * @return string Extension name
     */
    public function getName()
    {
        return 'share-extension';
    }

    /**
     * Twig function declarations
     *
     * @return array Twig instances
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('twitter', 'getTwitterLink'),
            new \Twig_SimpleFunction('facebook', 'getFacebookLink'),
            new \Twig_SimpleFunction('pinterest', 'getPinterestLink')
        );
    }



    /**
     * Crafts Twitter link
     *
     * @param string $url  URL to share
     * @param string $text Text to add to the tweet
     *
     * @return <a href="..."> content
     */
    public function getTwitterLink($url, $text = '')
    {
        return 'http://twitter.com/share?url='.rawurlencode($url).'&amp;text='.rawurlencode($text).'" onclick="window.open(this.href, \'\', \'directories=no,location=no,menubar=no,resizable=no,scrollbars=no,status=no,toolbar=no,width=640,height=435\'); return false;';
    }



    /**
     * Crafts Facebook link
     *
     * @param string $url URL to share
     *
     * @return <a href="..."> content
     */
    public function getFacebookLink($url)
    {
        return 'http://www.facebook.com/sharer/sharer.php?u='.rawurlencode($url).'" onclick="window.open(this.href, \'\', \'directories=no,location=no,menubar=no,resizable=no,scrollbars=no,status=no,toolbar=no,width=640,height=350\'); return false;';
    }



    /**
     * Crafts Pinterest link
     *
     * @param string $url   URL to share
     * @param string $media Media URL
     *
     * @return <a href="..."> content
     */
    public function getPinterestLink($url, $media)
    {
        return 'http://pinterest.com/pin/create/button/?url='.rawurlencode($url).'&amp;media='.rawurlencode($media).'" onclick="window.open(this.href, \'\', \'directories=no,location=no,menubar=no,resizable=no,scrollbars=no,status=no,toolbar=no,width=750,height=316\'); return false;';
    }
}
