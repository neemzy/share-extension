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

    const TWITTER_WIDTH = 640;
    const TWITTER_HEIGHT = 435;
    const FACEBOOK_WIDTH = 640;
    const FACEBOOK_HEIGHT = 350;
    const PINTEREST_WIDTH = 750;
    const PINTEREST_HEIGHT = 316;
    const TUMBLR_WIDTH = 640;
    const TUMBLR_HEIGHT = 435;
    const GOOGLE_WIDTH = 640;
    const GOOGLE_HEIGHT = 360;

    /**
     * @param SocialShare $socialShare
     */
    public function __construct(SocialShare $socialShare)
    {
        $this->socialShare = $socialShare;
    }

    /**
     * @return ShareExtension
     */
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
        return '" onclick="window.open(this.href, \'\', \'directories=no,location=no,menubar=no,resizable=no,scrollbars=no'.
            ',status=no,toolbar=no,width='.$width.',height='.$height.'\'); return false;';
    }



    /**
     * @param string $url
     * @param string $text
     *
     * @return string <a href="..."> content
     */
    public function getTwitterLink($url, $text = '')
    {
        return $this->socialShare->getLink(Twitter::NAME, $url, compact('text')).
            $this->appendHandler(TWITTER_WIDTH, TWITTER_HEIGHT);
    }



    /**
     * @param string $url
     *
     * @return string <a href="..."> content
     */
    public function getFacebookLink($url)
    {
        return $this->socialShare->getLink(Facebook::NAME, $url).
            $this->appendHandler(FACEBOOK_WIDTH, FACEBOOK_HEIGHT);
    }



    /**
     * @param string $url
     * @param string $media
     *
     * @return string <a href="..."> content
     */
    public function getPinterestLink($url, $media)
    {
        return $this->socialShare->getLink(Pinterest::NAME, $url, compact('media')).rawurlencode($media).
            $this->appendHandler(PINTEREST_WIDTH, PINTEREST_HEIGHT);
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
        return 'http://www.tumblr.com/share/link?url='.rawurlencode($url).'&amp;name='.$title.'&amp;description='.$description.
            $this->appendHandler(TUMBLR_WIDTH, TUMBLR_HEIGHT);
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
        return $this->socialShare->getLink(Google::NAME, $url).
            $this->appendHandler(GOOGLE_WIDTH, GOOGLE_HEIGHT);
    }
}
