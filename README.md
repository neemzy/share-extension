# ShareExtension

Twig extension providing social share links

## Installation

```
composer require neemzy/share-extension
```

## Usage

```twig
<a href="{{ twitter(my_url, 'Some text') }}">Share on Twitter</a>
<a href="{{ facebook(my_url) }}">Share on Facebook</a>
<a href="{{ pinterest(my_url, my_media_url) }}">Share on Pinterest</a>
<a href="{{ tumblr(my_url, 'Some text') }}">Share on Pinterest</a>
```