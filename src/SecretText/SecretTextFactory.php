<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\SecretText;

use Picamator\SteganographyKit2\SecretText\Api\EndMarkInterface;
use Picamator\SteganographyKit2\SecretText\Api\SecretTextFactoryInterface;
use Picamator\SteganographyKit2\SecretText\Api\SecretTextInterface;
use Picamator\SteganographyKit2\Text\Api\TextFactoryInterface;
use Picamator\SteganographyKit2\Util\Api\ObjectManagerInterface;

/**
 * Create SecretText object
 *
 * @codeCoverageIgnore
 */
class SecretTextFactory implements SecretTextFactoryInterface
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var TextFactoryInterface
     */
    private $textFactory;

    /**
     * @var EndMarkInterface
     */
    private $endMark;

    /**
     * @var string
     */
    private $className;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param TextFactoryInterface $textFactory
     * @param EndMarkInterface $endMark
     * @param string $className
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        TextFactoryInterface $textFactory,
        EndMarkInterface $endMark,
        string $className = 'Picamator\SteganographyKit2\SecretText\SecretText'
    ) {
        $this->objectManager = $objectManager;
        $this->textFactory = $textFactory;
        $this->endMark = $endMark;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(string $secretText) : SecretTextInterface
    {
        $text = $this->textFactory->create($secretText);

        return $this->objectManager->create($this->className, [$text, $this->endMark]);
    }
}
