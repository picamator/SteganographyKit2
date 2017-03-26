<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\File\NameGenerator;

use Picamator\SteganographyKit2\Kernel\File\Api\NameGeneratorInterface;

/**
 * Strategy to generate file name
 *
 * Add prefix with time to source name.
 *
 * Class type
 * ----------
 * Sharable service strategy. It's helper class as a namespace over ``generate`` function.
 *
 * Responsibility
 * --------------
 * Generate file name based on ``$sourceName``
 *
 * Immutability
 * ------------
 * Object is immutable.
 *
 * Dependency injection
 * --------------------
 * Only as constructor argument.
 *
 * @package Kernel\File
 */
class PrefixTime implements NameGeneratorInterface
{
    /**
     * @var string
     */
    private $prefix;

    /**
     * @param string $prefix
     */
    public function __construct(string $prefix = '')
    {
        $this->prefix = trim($prefix);
    }

    /**
     * @inheritDoc
     */
    public function generate(string $sourceName) : string
    {
        $name = $this->prefix === '' ? '' : $this->prefix . '-';
        $name .= time() . '-';
        $name .= pathinfo($sourceName, PATHINFO_BASENAME);

        return $name;
    }
}
