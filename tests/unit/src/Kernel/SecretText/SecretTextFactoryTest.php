<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\SecretText;

use Picamator\SteganographyKit2\Kernel\SecretText\SecretTextFactory;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class SecretTextFactoryTest extends BaseTest
{
    /**
     * @var SecretTextFactory
     */
    private $secretTextFactory;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $objectManagerMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\SecretText\Api\Iterator\IteratorFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $iteratorFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $infoMarkMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $secretTextMock;

    protected function setUp()
    {
        parent::setUp();

        $this->objectManagerMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface')
            ->getMock();

        $this->iteratorFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\SecretText\Api\Iterator\IteratorFactoryInterface')
            ->getMock();

        $this->infoMarkMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkInterface')
            ->getMock();

        $this->secretTextMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextInterface')
            ->getMock();

        $this->secretTextFactory = new SecretTextFactory($this->objectManagerMock, $this->iteratorFactoryMock);
    }

    public function testCreate()
    {
        $binaryText = '01010101';

        // object manager mock
        $this->objectManagerMock->expects($this->once())
            ->method('create')
            ->willReturn($this->secretTextMock);

        $this->secretTextFactory->create($this->infoMarkMock, $binaryText);
    }

    /**
     * @dataProvider providerInvalidCreate
     *
     * @expectedException \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     *
     * @param string $binaryText
     */
    public function testInvalidCreate(string $binaryText)
    {
        // never
        $this->objectManagerMock->expects($this->never())
            ->method('create');

        $this->secretTextFactory->create($this->infoMarkMock, $binaryText);
    }

    public function providerInvalidCreate()
    {
        return [
            [''],
            ['u'],
            ['1234567a']
        ];
    }
}
