<?php
namespace Picamator\SteganographyKit2\Tests\Helper\Entity;

use PHPUnit\Framework\TestCase;

/**
 * Help to mock Entity\Api\PixelInterface
 */
class PixelHelper
{
    /**
     * @var TestCase
     */
    private $testCase;

    /**
     * @param TestCase $testCase
     */
    public function __construct(TestCase $testCase)
    {
        $this->testCase = $testCase;
    }

    /**
     * Gets pixel list
     *
     * @param integer $count
     *
     * @return array
     */
    public function getPixelList(int $count) : array
    {
        $pixelList = [];
        for ($i = 0; $i < $count; $i++) {
            $pixelList[] = $this->getPixelMock();
        }

        return $pixelList;
    }

    /**
     * Gets pixel mock
     *
     * @return \Picamator\SteganographyKit2\Entity\PixelInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private function getPixelMock()
    {
        $color = [
            'red' => $this->getByteMock(),
            'green' => $this->getByteMock(),
            'blue' => $this->getByteMock(),
        ];

        $colorIterator = $this->getColorIterator($color);

        // color mock
        $colorMock = $this->getMockBuilder('Picamator\SteganographyKit2\Image\Api\Data\ColorInterface')
            ->getMock();

        $colorMock->method('toArray')
            ->willReturn($color);

        // pixel mock
        $pixelMock = $this->getMockBuilder('Picamator\SteganographyKit2\Entity\Api\PixelInterface')
            ->getMock();

        $pixelMock->method('getIterator')
            ->willReturn($colorIterator);

        $pixelMock->method('getColor')
            ->willReturn($colorMock);

        return $pixelMock;
    }

    /**
     * Gets byte mock
     *
     * @return \Picamator\SteganographyKit2\Primitive\Api\Data\ByteInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private function getByteMock(): \PHPUnit_Framework_MockObject_MockObject
    {
        return $this->getMockBuilder('Picamator\SteganographyKit2\Primitive\Api\Data\ByteInterface')
            ->getMock();
    }

    /**
     * Gets color iterator
     * @see http://php.net/manual/en/class.recursivearrayiterator.php#106519
     *
     * @param array $color
     *
     * @return  \RecursiveArrayIterator
     */
    private function getColorIterator(array $color) :  \RecursiveArrayIterator
    {
        return new class($color) extends \RecursiveArrayIterator
        {
            public function hasChildren()
            {
                return is_array($this->current());
            }
        };
    }

    /**
     * Gets mock builder
     *
     * @param string $className
     *
     * @return \PHPUnit_Framework_MockObject_MockBuilder
     */
    private function getMockBuilder(string $className) : \PHPUnit_Framework_MockObject_MockBuilder
    {
        return $this->testCase->getMockBuilder($className);
    }
}
