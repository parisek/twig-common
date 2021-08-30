Twig Common Extension
=====================

## Installation

Twig Common Extension can be easily installed using [composer](http://getcomposer.org/)

    composer require parisek/twig-common

## Usage

```php
$twig = new Twig_Environment($loader);
$twig->addExtension(new Parisek\Twig\CommonExtension());
```

## Filters

Will load YAML to variable
```twig
{% set sidebar = source('sidebar.yml')|yaml_parse %}
```

Will return content without translation (useful for debug without translation extension)
```twig
{{ "Hello"|t }}
```

## Functions

Will generate unique ID on the page
```twig
{{ uniqueId() }}
```

## Tokens
Will return content without translation (useful for debug without translation extension)

```twig
{% trans with {'context': 'domain name'} %}{{ variable }}{% endtrans %}
```
