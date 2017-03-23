<?php
namespace Picamator\SteganographyKit2\Kernel\StegoSystem\Api;

/**
 * Observer as a part observer pattern implementation
 *
 * @package Kernel\StegoSystem
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
