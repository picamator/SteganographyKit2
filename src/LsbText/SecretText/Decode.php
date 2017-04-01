<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\LsbText\SecretText;

use Picamator\SteganographyKit2\Kernel\SecretText\Api\DecodeInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextInterface;
use Picamator\SteganographyKit2\Kernel\Text\Api\FilterManagerInterface;

/**
 * Decode SecretText to original text
 *
 * Class type
 * ----------
 * Sharable service.
 *
 * Responsibility
 * --------------
 * Decode SecretText to text
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
final class Decode implements DecodeInterface
{
    /**
     * @var FilterManagerInterface
     */
    private $filterManager;

    /**
     * @param FilterManagerInterface $filterManager
     */
    public function __construct(FilterManagerInterface $filterManager)
    {
        $this->filterManager = $filterManager;
    }

    /**
     * @inheritDoc
     */
    public function decode(SecretTextInterface $secretText)
    {
       return $this->filterManager->apply($secretText->getBinaryText());
    }
}
