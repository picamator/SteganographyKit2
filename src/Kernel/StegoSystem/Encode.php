<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\StegoSystem;

use Picamator\SteganographyKit2\Kernel\CoverText\Api\CoverTextInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\RepositoryFactoryInterface;
use Picamator\SteganographyKit2\Kernel\StegoSystem\Api\EncodeBitInterface;
use Picamator\SteganographyKit2\Kernel\StegoSystem\Api\EncodeInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextInterface;
use Picamator\SteganographyKit2\Kernel\StegoText\Api\StegoTextFactoryInterface;
use Picamator\SteganographyKit2\Kernel\StegoText\Api\StegoTextInterface;

/**
 * Encode is converting SecretText and CoverText to StegoText
 *
 * Actual algorithm's implementation is concentrated inside CoverText, SecretText, StegoText iterators.
 */
class Encode implements EncodeInterface
{
    /**
     * @var EncodeBitInterface
     */
    private $encodeBit;

    /**
     * @var RepositoryFactoryInterface
     */
    private $repositoryFactory;

    /**
     * @var StegoTextFactoryInterface
     */
    private $stegoTextFactory;

    /**
     * @param EncodeBitInterface $encodeBit
     * @param RepositoryFactoryInterface $repositoryFactory
     * @param StegoTextFactoryInterface $stegoTextFactory
     */
    public function __construct(
        EncodeBitInterface $encodeBit,
        RepositoryFactoryInterface $repositoryFactory,
        StegoTextFactoryInterface $stegoTextFactory
    ) {
        $this->encodeBit = $encodeBit;
        $this->repositoryFactory = $repositoryFactory;
        $this->stegoTextFactory = $stegoTextFactory;
    }

    /**
     * @inheritDoc
     */
    public function encode(SecretTextInterface $secretText, CoverTextInterface $coverText): StegoTextInterface
    {
        $repository = $this->repositoryFactory->create($coverText->getImage());
        $iterator = new \MultipleIterator(\MultipleIterator::MIT_NEED_ALL | \MultipleIterator::MIT_KEYS_ASSOC);

        // secret text iterator
        $secretIterator = new \CachingIterator($secretText->getIterator());
        $iterator->attachIterator($secretIterator, 'secretBit');

        // cover text iterator (0) PixelInterface -> (1) ByteInterface
        $coverIterator = new \RecursiveIteratorIterator($coverText);
        $iterator->attachIterator($coverIterator, 'coverByte');

        $prevItem = $coverIterator->getSubIterator(0)->current();
        foreach ($iterator as $item) {
            // encode bit
            $colorKey = $coverIterator->getSubIterator(1)->key();
            $stegoByte = $this->encodeBit->encode((int)$item['secretBit'], $item['coverByte']);

            // update pixel
            if (isset($colorData[$colorKey])) {
                $repository->update($prevItem, $colorData);
                $colorData = [];
            }

            $colorData[$colorKey] = $stegoByte;

            // last iteration
            if (!$secretIterator->hasNext()) {
                $repository->update($coverIterator->getSubIterator(0)->current(), $colorData);
            }

            $prevItem = $coverIterator->getSubIterator(0)->current();
        }

        return $this->stegoTextFactory->create($coverText->getImage());
    }
}
