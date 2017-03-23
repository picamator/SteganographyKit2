<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Data;

use Picamator\SteganographyKit2\Kernel\Image\Api\Data\SizeInterface;

/**
 * Size value object
 *
 * @codeCoverageIgnore
 */
class Size implements SizeInterface
{
    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    /**
     * @param int $width
     * @param int $height
     */
    public function __construct(int $width, int $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * @inheritDoc
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @inheritDoc
     */
    public function getHeight(): int
    {
        return $this->height;
    }
}
