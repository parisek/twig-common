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

## Template

```twig
{% set sidebar = source('sidebar.yml')|yaml_parse %}
```

```twig
{{ uniqueId() }}
```
