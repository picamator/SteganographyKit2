<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Text\Data;

use Picamator\SteganographyKit2\Kernel\Text\Api\Data\TextInterface;

/**
 * Text value object
 *
 * @package Kernel\Text
 *
 * @codeCoverageIgnore
 */
final class Text implements TextInterface
{
    /**
     * @var string
     */
    private $text;

    /**
     * @var int
     */
    private $countText;

    /**
     * @param string $text
     */
    public function __construct(string $text)
    {
        $this->text = $text;
    }

    /**
     * @inheritDoc
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        if (is_null($this->countText)) {
            $this->countText = strlen($this->text);
        }

        return $this->countText;
    }
}
