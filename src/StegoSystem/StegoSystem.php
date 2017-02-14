<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\StegoSystem;

use Picamator\SteganographyKit2\CoverText\Api\CoverTextInterface;
use Picamator\SteganographyKit2\StegoSystem\Api\DecodeInterface;
use Picamator\SteganographyKit2\StegoSystem\Api\EncodeInterface;
use Picamator\SteganographyKit2\StegoSystem\Api\ObserverInterface;
use Picamator\SteganographyKit2\SecretText\Api\SecretTextInterface;
use Picamator\SteganographyKit2\StegoSystem\Api\StegoSystemInterface;
use Picamator\SteganographyKit2\StegoText\Api\StegoTextInterface;

/**
 * StegoSystem is a facade for Encode and Decode
 */
class StegoSystem implements StegoSystemInterface
{
    /**
     * @var EncodeInterface
     */
    private $encode;

    /**
     * @var DecodeInterface
     */
    private $decode;

    /**
     * @var array
     */
    private $observerContainer;

    /**
     * Decode and Encode should be configured as Proxy in DI
     *
     * @param EncodeInterface $encode
     * @param DecodeInterface $decode
     */
    public function __construct(EncodeInterface $encode, DecodeInterface $decode)
    {
        $this->encode = $encode;
        $this->decode = $decode;
    }

    /**
     * @inheritDoc
     *
     * @events beforeEncode, afterEncode
     */
    public function encode(SecretTextInterface $secretText, CoverTextInterface $coverText): StegoTextInterface
    {
        $this->notify('beforeEncode', $secretText, $coverText);
        $result = $this->encode->encode($secretText, $coverText);
        $this->notify('afterEncode', $result);

        return $result;
    }

    /**
     * @inheritDoc
     *
     * @events beforeDecode, afterDecode
     */
    public function decode(StegoTextInterface $stegoText): SecretTextInterface
    {
        $this->notify('beforeDecode', $stegoText);
        $result = $this->decode->decode($stegoText);
        $this->notify('afterDecode', $result);

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function attach(string $name, ObserverInterface $observer): StegoSystemInterface
    {
        $observerList = $this->getObserverList($name);
        $observerList->attach($observer);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function detach(string $name, ObserverInterface $observer): StegoSystemInterface
    {
        $observerList = $this->getObserverList($name);
        $observerList->detach($observer);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function notify(string $name, ...$data)
    {
        // skip empty observer
        if (is_null($this->observerContainer)) {
            return;
        }

        $observerList = $this->getObserverList($name);
        /** @var ObserverInterface $item */
        foreach ($observerList as $item) {
            $item->update($this, $data);
        }
    }

    /**
     * Retrieve observer list
     *
     * @param string $name
     *
     * @return \SplObjectStorage
     */
    private function getObserverList(string $name): \SplObjectStorage
    {
        if (empty($this->observerContainer[$name])) {
            $this->observerContainer[$name] = new \SplObjectStorage();
        }

        return $this->observerContainer[$name];
    }
}
