<?php

namespace Neemzy\Twig\Extension;

use Doctrine\Common\Cache\PhpFileCache;
use SocialShare\SocialShare;
use SocialShare\Provider\Facebook;
use SocialShare\Provider\Twitter;
use SocialShare\Provider\Google;
use SocialShare\Provider\Pinterest;

class ShareExtension extends \Twig_Extension
{
    /** @var SocialShare */
    private $socialShare;

    /**
     * @param SocialShare $socialShare
     */
    public function __construct(SocialShare $socialShare)
    {
        $this->socialShare = $socialShare;
    }

    public static function getInstance()
    {
        $socialShare = new SocialShare(new PhpFileCache(sys_get_temp_dir()));

        $socialShare->registerProvider(new Twitter());
        $socialShare->registerProvider(new Facebook());
        $socialShare->registerProvider(new Pinterest());
        $socialShare->registerProvider(new Google());

        return new self($socialShare);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'share-extension';
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('twitter', [$this, 'getTwitterLink'], ['is_safe' => ['all']]),
            new \Twig_SimpleFunction('facebook', [$this, 'getFacebookLink'], ['is_safe' => ['all']]),
            new \Twig_SimpleFunction('pinterest', [$this, 'getPinterestLink'], ['is_safe' => ['all']]),
            new \Twig_SimpleFunction('tumblr', [$this, 'getTumblrLink'], ['is_safe' => ['all']]),
            new \Twig_SimpleFunction('google', [$this, 'getGoogleLink'], ['is_safe' => ['all']])
        ];
    }



    /**
     * Appends onclick handler to the link to make it open a popup
     *
     * @param int $width
     * @param int $height
     *
     * @return string
     */
    private function appendHandler($width, $height)
    {
        return '" onclick="window.open(this.href, \'\', \'directories=no,location=no,menubar=no,resizable=no,scrollbars=no,status=no,toolbar=no,width='.$width.',height='.$height.'\'); return false;';
    }



    /**
     * @param string $url
     * @param string $text
     *
     * @return string <a href="..."> content
     */
    public function getTwitterLink($url, $text = '')
    {
        return $this->socialShare->getLink(Twitter::NAME, $url, compact('text')).$this->appendHandler(640, 435);
    }



    /**
     * @param string $url
     *
     * @return string <a href="..."> content
     */
    public function getFacebookLink($url)
    {
        return $this->socialShare->getLink(Facebook::NAME, $url).$this->appendHandler(640, 350);
    }



    /**
     * @param string $url
     * @param string $media
     *
     * @return string <a href="..."> content
     */
    public function getPinterestLink($url, $media)
    {
        return $this->socialShare->getLink(Pinterest::NAME, $url, compact('media')).rawurlencode($media).$this->appendHandler(750, 316);
    }



    /**
     * @param string $url
     * @param string $title
     * @param string $description
     *
     * @return string <a href="..."> content
     */
    public function getTumblrLink($url, $title = '', $description = '')
    {
        return 'http://www.tumblr.com/share/link?url='.rawurlencode($url).'&amp;name='.$title.'&amp;description='.$description.$this->appendHandler(640, 435);
    }



    /**
     * @param string $url
     * @param string $title
     * @param string $description
     *
     * @return string <a href="..."> content
     */
    public function getGoogleLink($url, $title = '', $description = '')
    {
        return $this->socialShare->getLink(Google::NAME, $url).$this->appendHandler(640, 360);
    }
}
