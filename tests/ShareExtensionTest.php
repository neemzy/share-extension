<?php

require(__DIR__.'/../src/ShareExtension.php');

class ShareExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test warmer
     * Instantiates the extension
     *
     * @return void
     */
    protected function setUp()
    {
        $this->instance = new ShareExtension\ShareExtension;
    }



    /**
     * Test Twitter link
     *
     * @return void
     */
    public function testTwitterLink()
    {
        $this->assertEquals(
            'http://twitter.com/share?url=http%3A%2F%2Fwww.zaibatsu.fr&amp;text=Some%20cool%20website" onclick="window.open(this.href, \'\', \'directories=no,location=no,menubar=no,resizable=no,scrollbars=no,status=no,toolbar=no,width=640,height=435\'); return false;',
            $this->instance->getTwitterLink('http://www.zaibatsu.fr', 'Some cool website')
        );
    }



    /**
     * Test Facebook link
     *
     * @return void
     */
    public function testFacebookLink()
    {
        $this->assertEquals(
            'http://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwww.zaibatsu.fr" onclick="window.open(this.href, \'\', \'directories=no,location=no,menubar=no,resizable=no,scrollbars=no,status=no,toolbar=no,width=640,height=350\'); return false;',
            $this->instance->getFacebookLink('http://www.zaibatsu.fr')
        );
    }



    /**
     * Test Pinterest link
     *
     * @return void
     */
    public function testPinterestLink()
    {
        $this->assertEquals(
            'http://pinterest.com/pin/create/button/?url=http%3A%2F%2Fwww.zaibatsu.fr&amp;media=http%3A%2F%2Fimages.smh.com.au%2F2012%2F11%2F08%2F3778668%2Fmeme1.jpg" onclick="window.open(this.href, \'\', \'directories=no,location=no,menubar=no,resizable=no,scrollbars=no,status=no,toolbar=no,width=750,height=316\'); return false;',
            $this->instance->getPinterestLink('http://www.zaibatsu.fr', 'http://images.smh.com.au/2012/11/08/3778668/meme1.jpg')
        );
    }
}
