<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Text;

use Picamator\SteganographyKit2\Kernel\Text\Api\Data\LengthInterface;
use Picamator\SteganographyKit2\Kernel\Text\Api\LengthFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;

/**
 * Create Length object
 *
 * Class type
 * ----------
 * Sharable service.
 *
 * Responsibility
 * --------------
 * Create ``Length``.
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
 * @package Kernel\Text
 *
 * @codeCoverageIgnore
 */
class LengthFactory implements LengthFactoryInterface
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var string
     */
    private $className;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param string $className
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        string $className = 'Picamator\SteganographyKit2\Kernel\Text\Data\Length'
    ) {
        $this->objectManager = $objectManager;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(string $text) : LengthInterface
    {
        return $this->objectManager->create($this->className, [$text]);
    }
}
