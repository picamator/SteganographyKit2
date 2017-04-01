<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\SecretText;

use Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextFactoryInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextInterface;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;

/**
 * Create SecretText object
 *
 * Class type
 * ----------
 * Sharable service.
 *
 * Responsibility
 * --------------
 * Create ``SecretText``.
 *
 * State
 * -----
 * No state
 *
 * Immutability
 * ------------
 * Object is immutable.
 *
 * Dependency injection
 * --------------------
 * Only as a constructor argument.
 *
 * @package Kernel\SecretText
 */
final class SecretTextFactory implements SecretTextFactoryInterface
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var IteratorFactoryInterface
     */
    private $iteratorFactory;

    /**
     * @var string
     */
    private $className;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param IteratorFactoryInterface $iteratorFactory,
     * @param string $className
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        IteratorFactoryInterface $iteratorFactory,
        string $className = 'Picamator\SteganographyKit2\Kernel\SecretText\SecretText'
    ) {
        $this->objectManager = $objectManager;
        $this->iteratorFactory = $iteratorFactory;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(InfoMarkInterface $infoMark, string $binaryText) : SecretTextInterface
    {
        if (empty($binaryText) || preg_match('/[^01]+/', $binaryText) === 1) {
            throw new InvalidArgumentException('Invalid binaryText. BinaryText should contain 0 or 1.');
        }

        return $this->objectManager->create($this->className, [$infoMark, $this->iteratorFactory, $binaryText]);
    }
}
