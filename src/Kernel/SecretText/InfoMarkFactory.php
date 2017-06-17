<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\SecretText;

use Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\SizeInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Builder\SizeFactory;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkFactoryInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextConstant;

/**
 * Create InfoMark object
 *
 * @package Kernel\SecretText
 */
final class InfoMarkFactory implements InfoMarkFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function create(string $binaryString) : InfoMarkInterface
    {
        if (strlen($binaryString) < SecretTextConstant::INFO_MARK_LENGTH) {
            throw new InvalidArgumentException(
                sprintf('Failed create InfoMark object from binary string "%s". Binary string is shorter then "%s" bits.', $binaryString, self::MARK_COUNT)
            );
        }

        $infoDoubleByte = str_split($binaryString, SecretTextConstant::INFO_MARK_LENGTH / 2);
        $infoDoubleByte = array_map('bindec', $infoDoubleByte);

        $size = $this->createSize($infoDoubleByte[0], $infoDoubleByte[1]);

        return new InfoMark($size);
    }

    /**
     * Create size
     *
     * @param int $width
     * @param int $height
     *
     * @return SizeInterface
     */
    private function createSize(int $width, int $height) : SizeInterface
    {
        return SizeFactory::create($width, $height);
    }
}
