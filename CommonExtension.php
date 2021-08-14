<?php

namespace Parisek\Twig;

use Symfony\Component\Yaml\Yaml;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

final class CommonExtension extends AbstractExtension {

  public function getFunctions()  {
    return [
      new TwigFunction('uniqueId', [
        $this,
        'getUniqueId'
      ]),
    ];
  }

  public function getFilters() {
    return [
      new TwigFilter('yaml_parse', [
        $this,
        'yamlParse',
      ], [
        'is_safe' => [
          'html'
        ]
      ]),
      new TwigFilter('format_price', [
        $this,
        'formatPrice'
      ]),
    ];
  }

  public function getUniqueId() {

    // generate a random string
    $id = bin2hex(random_bytes(3));

    // check if it's already set
    while (in_array($id, $this->uniqueIds, true)) {
      // if so, use another one
      $id = bin2hex(random_bytes(3));
    }
    // set it as "used"
    $this->uniqueIds[] = $id;

    return $id;
  }

  public function yamlParse($content) {
    return Yaml::parse($content);
  }
}
