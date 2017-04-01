<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\LsbText\SecretText;

use Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\EncodeInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkFactoryInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextFactoryInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextInterface;
use Picamator\SteganographyKit2\Kernel\Text\Api\FilterManagerInterface;

/**
 * Encode text to SecretText
 *
 * Class type
 * ----------
 * Sharable service.
 *
 * Responsibility
 * --------------
 * Encode string data to binary SecretText
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
 * @package LsbText\SecretText
 */
final class Encode implements EncodeInterface
{
    /**
     * @var FilterManagerInterface
     */
    private $filterManager;

    /**
     * @var InfoMarkFactoryInterface
     */
    private $infoMarkFactory;

    /**
     * @var SecretTextFactoryInterface
     */
    private $secretTextFactory;

    /**
     * @param FilterManagerInterface $filterManager
     * @param InfoMarkFactoryInterface $infoMarkFactory
     * @param SecretTextFactoryInterface $secretTextFactory
     */
    public function __construct(
        FilterManagerInterface $filterManager,
        InfoMarkFactoryInterface $infoMarkFactory,
        SecretTextFactoryInterface $secretTextFactory
    ) {
        $this->filterManager = $filterManager;
        $this->infoMarkFactory = $infoMarkFactory;
        $this->secretTextFactory = $secretTextFactory;
    }

    /**
     * @inheritDoc
     *
     * @param string $data
     */
    public function encode($data): SecretTextInterface
    {
        if (!is_string($data)) {
            throw new InvalidArgumentException(
                sprintf('Encoded data type "%s" is not a string.', gettype($data))
            );
        }

        $encodedText = $this->filterManager->apply($data);
        $infoMark = $this->infoMarkFactory->create(strlen($data), 0);

        return $this->secretTextFactory->create($infoMark, $encodedText);
    }
}
