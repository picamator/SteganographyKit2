<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Text;

use Picamator\SteganographyKit2\Text\Api\Data\LengthInterface;
use Picamator\SteganographyKit2\Text\Api\LengthFactoryInterface;
use Picamator\SteganographyKit2\Util\Api\ObjectManagerInterface;

/**
 * Create Length object
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
        string $className = 'Picamator\SteganographyKit2\Text\Data\Length'
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
