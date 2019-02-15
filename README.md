For Kirby v.3.

This plugin replaces the default `(image: ...)` tag with a version that resizes the image to a maximum size specified in your `config.php`.
It also allows you to redefine the generated HTML code via a snippet.

## Installation

### Download

Download and copy this repository to `/site/plugins/k3-image-tag`.

### Git submodule

```
git submodule add https://github.com/rasteiner/k3-image-tag.git site/plugins/k3-image-tag
```

### Composer

```
composer require rasteiner/k3-image-tag
```

## Setup

### Example for simply resizing the image:

`site/config/config.php`:

```php
return [
  'imagetag' => [
    'max-width': 1400
  ]
];
```

### Example snippet for a custom snippet:

`site/config/config.php`:

```php
return [
  'imagetag' => [
    'snippet': 'imagetag'
  ]
];
```

`site/snippets/imagetag.php`:

```php
<a href="<?= $image->resize(2000)->url() ?>" data-fancybox="page">
  <img src="<?= $image->resize(900)->url() ?>" alt="<?= html($alt) ?? $image->alt()->html() ?>" />
</a>
```

The following `$variables` are passed to the snippet:
 - `$image`: the resolved File object to the original image passed to the tag
 - All [attributes](https://getkirby.com/docs/reference/text/kirbytags/image) specified in the tag are [extracted](http://php.net/manual/en/function.extract.php) to variables.


## License

MIT

## Credits

- [Roman Steiner](https://github.com/rasteiner)

Plugin based on the [`getkirby/pluginkit`](https://github.com/getkirby/pluginkit) template, made by [lukasbestle](https://github.com/lukasbestle).
