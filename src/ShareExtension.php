<?php

namespace Neemzy\Twig\Extension\Share;

use Doctrine\Common\Cache\PhpFileCache;
use SocialShare\SocialShare;
use SocialShare\Provider\Facebook;
use SocialShare\Provider\Google;
use SocialShare\Provider\LinkedIn;
use SocialShare\Provider\Pinterest;
use SocialShare\Provider\ScoopIt;
use SocialShare\Provider\StumbleUpon;
use SocialShare\Provider\Twitter;

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

        $socialShare->registerProvider(new Facebook());
        $socialShare->registerProvider(new Google());
        $socialShare->registerProvider(new LinkedIn());
        $socialShare->registerProvider(new Pinterest());
        $socialShare->registerProvider(new ScoopIt());
        $socialShare->registerProvider(new StumbleUpon());
        $socialShare->registerProvider(new Twitter());

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
            new \Twig_SimpleFunction('share_url_*', [$this, 'getShareLinkUrl']),
            new \Twig_SimpleFunction('share_click_*', [$this, 'getShareLinkClickHandler']),
            new \Twig_SimpleFunction('share_count_*', [$this, 'getShareCount'])
        ];
    }

    /**
     * @param string $provider
     * @param string $url
     * @param array  $options
     *
     * @return string
     * @throws \RuntimeException If requested provider is undefined
     */
    public function getShareLinkUrl($provider, $url, array $options = array())
    {
        /** @see https://github.com/dunglas/php-socialshare/pull/20 */
        if ('tumblr' == $provider) {
            $shareUrl = 'http://www.tumblr.com/share/link?%s';
            $options['url'] = $url;

            return sprintf($shareUrl, http_build_query($options, null, '&'));
        }

        return $this->socialShare->getLink($provider, $url, $options);
    }

    /**
     * @param string $provider
     *
     * @return string
     */
    public function getShareLinkClickHandler($provider)
    {
        $constantPrefix = get_class($this).'::'.strtoupper($provider);
        $widthConstant = $constantPrefix.'_WIDTH';
        $heightConstant = $constantPrefix.'_HEIGHT';

        $handler = 'window.open(this.href, \'\', \'directories=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no';

        if (defined($widthConstant)) {
            $handler .= sprintf(',width=%s', constant($widthConstant));
        }

        if (defined($heightConstant)) {
            $handler .= sprintf(',height=%s', constant($heightConstant));
        }

        $handler .= '\'); return false;';
        return $handler;
    }

    /**
     * @param string $provider
     * @param string $url
     *
     * @return int
     * @throws \RuntimeException If requested provider is undefined
     */
    public function getShareCount($provider, $url)
    {
        /** @see https://github.com/dunglas/php-socialshare/pull/20 */
        if ('tumblr' == $provider) {
            return 0;
        }

        return $this->socialShare->getShares($provider, $url);
    }
}
