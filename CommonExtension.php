<?php

namespace Parisek\Twig;

use Symfony\Component\Yaml\Yaml;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Parisek\Twig\TransTokenParser;

final class CommonExtension extends AbstractExtension {

  public $uniqueIds = [];

  public function getFunctions() {
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
      new TwigFilter('t', [
        $this,
        'trans'
      ]),
    ];
  }

  public function getTokenParsers() {
    return [
      new TransTokenParser()
    ];
  }

  public function getUniqueId() {

    // generate a random string
    // prefix with random letter as HTML id cannot start with number
    $id = chr(rand(97,122)) . bin2hex(random_bytes(3));

    // check if it's already set
    while (in_array($id, $this->uniqueIds, true)) {
      // if so, use another one
      $id = chr(rand(97,122)) . bin2hex(random_bytes(3));
    }
    // set it as "used"
    $this->uniqueIds[] = $id;

    return $id;
  }

  public function yamlParse($content) {
    return Yaml::parse($content);
  }

  public function trans($content) {
    return $content;
  }
}
