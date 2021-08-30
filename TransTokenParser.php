<?php

namespace Parisek\Twig;

use Twig\TokenParser\AbstractTokenParser;

class TransTokenParser extends AbstractTokenParser {

  /**
   * {@inheritdoc}
   */
  public function parse(\Twig\Token $token)
  {
    $lineno = $token->getLine();
    $stream = $this->parser->getStream();

    $parameters = null;

    // parse optional data passed after `with` keyword
    if ($stream->nextIf(\Twig_Token::NAME_TYPE, 'with')) {
        $parameters = $this->parser->getExpressionParser()->parseExpression();
    }

    $stream->expect(\Twig\Token::BLOCK_END_TYPE);
    $body = $this->parser->subparse(array($this, 'decideTransEnd'), true);
    $stream->expect(\Twig\Token::BLOCK_END_TYPE);

    // just return content
    return $body;
  }

  /**
   * Decide if current token marks end of Markdown block.
   *
   * @param \Twig\Token $token
   * @return bool
   */
  public function decideTransEnd(\Twig\Token $token)
  {
    return $token->test('endtrans');
  }

  /**
   * {@inheritdoc}
   */
  public function getTag()
  {
    return 'trans';
  }
}
