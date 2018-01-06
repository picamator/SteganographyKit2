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
     * @var \Picamator\SteganographyKit2\Kernel\SecretText\Api\Iterator\IteratorFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $iteratorFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $infoMarkMock;

    protected function setUp()
    {
        parent::setUp();

        $this->iteratorFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\SecretText\Api\Iterator\IteratorFactoryInterface')
            ->getMock();

        $this->infoMarkMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkInterface')
            ->getMock();

        $this->secretTextFactory = new SecretTextFactory($this->iteratorFactoryMock);
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
