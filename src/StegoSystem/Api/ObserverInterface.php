<?php
namespace Picamator\SteganographyKit2\StegoSystem\Api;

/**
 * Observer as a part observer pattern implementation
 */
interface ObserverInterface
{
    /**
     * Update
     *
     * @param StegoSystemInterface $subject
     * @param array $data
     */
    public function update(StegoSystemInterface $subject, array $data);
}
