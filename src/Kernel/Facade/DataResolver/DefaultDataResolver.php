<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Facade\DataResolver;

/**
 * Default data resolver
 *
 * @package Kernel\Facade
 */
final class DefaultDataResolver extends AbstractDataResolver
{
    /**
     * @inheritDoc
     */
    protected function process($data)
    {
        return $this->dataFactory->create((string) $data);
    }
}
