# ShareExtension

Twig extension providing social sharing links

## Why?

Using this library instead of widgets provided by social platforms will allow you to get rid of:

- JavaScript execution timing issues
- Appearance constraints
- Abusive user tracking

## Installation

```
composer require neemzy/share-extension
```

## Usage

This library uses [PHP SocialShare](https://github.com/dunglas/php-socialshare) internally, and allows you to generate a sharing link and retrieve a share count for any of the providers it supports ([see the list](https://github.com/dunglas/php-socialshare#php-socialshare)).

You can also generate the contents for a `onclick` handler to make your sharing link a popup on JavaScript-capable browsers, which will use each provider's ideal popup size if available. The handler relies on the link's `href` attribute in order to be able to degrade gracefully, so be sure to use it in conjunction with the URL generation.

Provider-specific parameters (e.g. tweet contents for Twitter) are supported: [see the list](https://github.com/dunglas/php-socialshare/blob/master/examples/buttons.php).

```php
use Neemzy\Twig\Extension\Share\ShareExtension;

// You can get a ready-to-use instance...
$shareExtension = ShareExtension::getInstance();

// ...or instantiate it yourself
$shareExtension = new ShareExtension($phpSocialShareInstance);

$twig->addExtension($shareExtension);
```

```twig
<a href="{{ share_url_facebook(my_url) }}">Share on Facebook</a>
<a href="{{ share_url_twitter(my_url, { 'text': 'Some text' }) }}">Share on Twitter with some text</a>
<a href="{{ share_url_google(my_url) }}" onclick="{{ share_click_google() }}">Share on Google+ in a popup</a>
<div>Shared on Pinterest {{ share_count_pinterest(my_url) }} times.</div>
```
