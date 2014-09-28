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
            new \Twig_SimpleFunction('twitter', [$this, 'getTwitterLink'], ['is_safe' => ['all']]),
            new \Twig_SimpleFunction('facebook', [$this, 'getFacebookLink'], ['is_safe' => ['all']]),
            new \Twig_SimpleFunction('pinterest', [$this, 'getPinterestLink'], ['is_safe' => ['all']]),
            new \Twig_SimpleFunction('tumblr', [$this, 'getTumblrLink'], ['is_safe' => ['all']]),
            new \Twig_SimpleFunction('googleplus', [$this, 'getGooglePlusLink'], ['is_safe' => ['all']])
        );
    }



    /**
     * Appends onclick handler to the link to make it open a popup
     *
     * @param int $width  Pop-up width
     * @param int $height Pop-up height
     *
     * @return string HTML to append to the link
     */
    private function appendHandler($width, $height)
    {
        return '" onclick="window.open(this.href, \'\', \'directories=no,location=no,menubar=no,resizable=no,scrollbars=no,status=no,toolbar=no,width='.$width.',height='.$height.'\'); return false;';
    }



    /**
     * Crafts Twitter link
     *
     * @param string $url  URL to share
     * @param string $text Text to tweet
     *
     * @return string <a href="..."> content
     */
    public function getTwitterLink($url, $text = '')
    {
        return 'http://twitter.com/share?url='.rawurlencode($url).'&amp;text='.rawurlencode($text).$this->appendHandler(640, 435);
    }



    /**
     * Crafts Facebook link
     *
     * @param string $url URL to share
     *
     * @return string <a href="..."> content
     */
    public function getFacebookLink($url)
    {
        return 'http://www.facebook.com/sharer/sharer.php?u='.rawurlencode($url).$this->appendHandler(640, 350);
    }



    /**
     * Crafts Pinterest link
     *
     * @param string $url   URL to share
     * @param string $media Media URL
     *
     * @return string <a href="..."> content
     */
    public function getPinterestLink($url, $media)
    {
        return 'http://pinterest.com/pin/create/button/?url='.rawurlencode($url).'&amp;media='.rawurlencode($media).$this->appendHandler(750, 316);
    }



    /**
     * Crafts Tumblr link
     *
     * @param string $url         URL to share
     * @param string $title       Title to use
     * @param string $description Description to use
     *
     * @return string <a href="..."> content
     */
    public function getTumblrLink($url, $title = '', $description = '')
    {
        return 'http://www.tumblr.com/share/link?url='.rawurlencode($url).'&amp;name='.$title.'&amp;description='.$description.$this->appendHandler(640, 435);
    }



    /**
     * Crafts Google+ link
     *
     * @param string $url         URL to share
     * @param string $title       Title to use
     * @param string $description Description to use
     *
     * @return string <a href="..."> content
     */
    public function getGooglePlusLink($url, $title = '', $description = '')
    {
        return 'https://plus.google.com/share?url='.rawurlencode($url).$this->appendHandler(640, 360);
    }
}
