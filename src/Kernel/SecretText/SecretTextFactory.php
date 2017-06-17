<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\SecretText;

use Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextFactoryInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextInterface;

/**
 * Create SecretText object
 *
 * @package Kernel\SecretText
 */
final class SecretTextFactory implements SecretTextFactoryInterface
{
    /**
     * @var IteratorFactoryInterface
     */
    private $iteratorFactory;

    /**
     * @param IteratorFactoryInterface $iteratorFactory,
     */
    public function __construct(IteratorFactoryInterface $iteratorFactory)
    {
        $this->iteratorFactory = $iteratorFactory;
    }

    /**
     * @inheritDoc
     */
    public function create(InfoMarkInterface $infoMark, string $binaryText) : SecretTextInterface
    {
        if (empty($binaryText) || preg_match('/[^01]+/', $binaryText) === 1) {
            throw new InvalidArgumentException('Invalid binaryText. BinaryText should contain 0 or 1.');
        }


        return new SecretText($infoMark, $this->iteratorFactory, $binaryText);
    }
}
