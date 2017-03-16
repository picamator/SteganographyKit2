<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Text;

use Picamator\SteganographyKit2\Kernel\Text\Api\FilterManagerInterface;
use Picamator\SteganographyKit2\Kernel\Text\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Text\Api\LengthFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Text\Api\TextFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Text\Api\TextInterface;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;

/**
 * Create Text object
 */
class TextFactory implements TextFactoryInterface
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var FilterManagerInterface
     */
    private $filterManager;

    /**
     * @var IteratorFactoryInterface
     */
    private $iteratorFactory;

    /**
     * @var LengthFactoryInterface
     */
    private $lengthFactory;

    /**
     * @var string
     */
    private $className;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param FilterManagerInterface $filterManager
     * @param IteratorFactoryInterface $iteratorFactory
     * @param LengthFactoryInterface $lengthFactory
     * @param string $className
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        FilterManagerInterface $filterManager,
        IteratorFactoryInterface $iteratorFactory,
        LengthFactoryInterface $lengthFactory,
        string $className = 'Picamator\SteganographyKit2\Kernel\Text\Text'
    ) {
        $this->objectManager = $objectManager;
        $this->filterManager = $filterManager;
        $this->iteratorFactory = $iteratorFactory;
        $this->lengthFactory = $lengthFactory;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(string $text) : TextInterface
    {
        $text = $this->filterManager->apply($text);

        return $this->objectManager->create($this->className, [$this->iteratorFactory, $this->lengthFactory, $text]);
    }
}
