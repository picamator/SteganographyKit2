<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Text\Filter;

use Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;
use Picamator\SteganographyKit2\Kernel\Exception\RuntimeException;
use Picamator\SteganographyKit2\Kernel\Text\Api\FilterInterface;

/**
 * Compress text using Zip
 *
 * @package Kernel\Text\Filter
 */
final class ZipCompressFilter implements FilterInterface
{
    /**
     * @var array
     */
    private static $compressLevelList = [-1, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9];

    /**
     * @var int
     */
    private $compressLevel;

    /**
     * @param int $compressLevel from 0 - 9, value -1 means to use default configuration
     *
     * @throws InvalidArgumentException
     */
    public function __construct(int $compressLevel = -1)
    {
        if (!in_array($compressLevel, self::$compressLevelList)) {
            throw new InvalidArgumentException(
                sprintf('Invalid compress level "%s". Please choose correct one from a list [%s].',
                    $compressLevel, implode(', ', self::$compressLevelList))
            );
        }

        $this->compressLevel = $compressLevel;
    }

    /**
     * @inheritDoc
     */
    public function filter(string $text): string
    {
        $result = gzcompress($text, $this->compressLevel);
        // @codeCoverageIgnoreStart
        if ($result === false) {
            throw new RuntimeException(
                sprintf('Failed compressing string "%s"', $text)
            );
        }
        // @codeCoverageIgnoreEnd

        return $result;
    }
}
