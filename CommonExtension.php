<?php

namespace Parisek\Twig;

use Symfony\Component\Yaml\Yaml;
use CommerceGuys\Intl\Currency\CurrencyRepository;
use CommerceGuys\Intl\NumberFormat\NumberFormatRepository;
use CommerceGuys\Intl\Formatter\CurrencyFormatter;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

final class CommonExtension extends AbstractExtension {

  private $numberFormatterPrototype;

  public function __construct(\NumberFormatter $numberFormatterPrototype = null) {
    $this->numberFormatterPrototype = $numberFormatterPrototype;
  }

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

  public function formatPrice($price, array $options = []) {
    if (empty($price)) {
      return '';
    }
    elseif (is_array($price) && isset($price['currency_code']) && isset($price['number'])) {
      $numberFormatRepository = new NumberFormatRepository;
      $currencyRepository = new CurrencyRepository;
      $currencyFormatter = new CurrencyFormatter($numberFormatRepository, $currencyRepository);
      return $currencyFormatter->format($price['number'], $price['currency_code'], $options);
    }
    else {
      throw new \InvalidArgumentException('The "format_price" filter must be given an array with "number" and "currency_code" keys.');
    }
  }
}
