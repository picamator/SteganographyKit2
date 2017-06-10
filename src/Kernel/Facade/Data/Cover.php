<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Facade\Data;

use Picamator\SteganographyKit2\Kernel\Facade\Api\Data\CoverInterface;

/**
 * Cover value object
 *
 * Use composition to extend value object. Don't run ``__construct`` directly to modify object.
 * Protection to run ``__construct`` twice was not added for performance reason supposing the client code has height level of trust.
 *
 * @package Kernel\Facade
 *
 * @codeCoverageIgnore
 */
final class Cover implements CoverInterface
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * @param string $data
     */
    public function __construct(string $data)
    {
        $this->data = $data;
    }

    /**
     * @inheritDoc
     */
    public function getData() : string
    {
        return $this->data;
    }
}
