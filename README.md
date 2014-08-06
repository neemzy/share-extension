# ShareExtension

Twig extension providing social share links

## Installation

```
composer require neemzy/share-extension
```

## Usage

```twig
<a href="{{ twitter(my_url, 'Tweet this text') }}">Share on Twitter</a>
<a href="{{ twitter(my_url) }}">Share on Facebook</a>
<a href="{{ twitter(my_url, my_media_url) }}">Share on Pinterest</a>
```