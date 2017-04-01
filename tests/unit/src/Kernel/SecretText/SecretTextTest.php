<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\SecretText;

use Picamator\SteganographyKit2\Kernel\SecretText\SecretText;
use Picamator\SteganographyKit2\Tests\Helper\Kernel\IteratorHelper;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class SecretTextTest extends BaseTest
{
    /**
     * @var IteratorHelper
     */
    private $iteratorHelper;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $infoMarkMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\SecretText\Api\Iterator\IteratorFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $iteratorFactoryMock;

    protected function setUp()
    {
        parent::setUp();

        // helper
        $this->iteratorHelper = new IteratorHelper($this);

        $this->infoMarkMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkInterface')
            ->getMock();

        $this->iteratorFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\SecretText\Api\Iterator\IteratorFactoryInterface')
            ->getMock();
    }

    public function testGetIterator()
    {
        $binaryTextCount = 8;
        $binaryText = str_repeat('1', $binaryTextCount);

        $infoMarkCount = 32;
        $infoMark = str_repeat('0', $infoMarkCount);

        $iterator = $this->iteratorHelper->getIteratorMock(
            'Picamator\SteganographyKit2\Kernel\SecretText\Api\Iterator\IteratorInterface',
            str_split($binaryText)
        );

        // iterator factory mock
        $this->iteratorFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($iterator);

        // info mark mock
        $this->infoMarkMock->expects($this->once())
            ->method('getIterator')
            ->willReturn(new \ArrayIterator(str_split($infoMark)));

        $secretText = new SecretText($this->infoMarkMock, $this->iteratorFactoryMock, $binaryText);

        $secretText->getIterator();
        $secretText->getIterator(); // double run to test cache

        $actual = '';
        foreach($secretText as $item) {
            $actual .= $item;
        }

        $this->assertEquals($infoMark . $binaryText, $actual);
        $this->assertEquals($infoMarkCount + $binaryTextCount, strlen($actual));
    }
}
