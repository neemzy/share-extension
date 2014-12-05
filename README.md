# ShareExtension

Twig extension providing social sharing links

## Why ?

Using this library instead of widgets provided by social platforms will allow you to get rid of :

- JavaScript execution timing issues
- Appearance constraints
- Abusive user tracking

## Installation

```
composer require neemzy/share-extension
```

## Usage

```twig
<a href="{{ twitter(my_url, 'Some text') }}">Share on Twitter</a>
<a href="{{ facebook(my_url) }}">Share on Facebook</a>
<a href="{{ pinterest(my_url, my_media_url) }}">Share on Pinterest</a>
<a href="{{ tumblr(my_url, 'Some title', 'Some description') }}">Share on Tumblr</a>
<a href="{{ googleplus(my_url) }}">Share on Google+</a>
```
