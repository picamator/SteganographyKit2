<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\SecretText;

use Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextConstant;
use Picamator\SteganographyKit2\Kernel\SecretText\InfoMarkFactory;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class InfoMarkFactoryTest extends BaseTest
{
    /**
     * @var InfoMarkFactory
     */
    private $infoMarkFactory;

    protected function setUp()
    {
        parent::setUp();

        $this->infoMarkFactory = new InfoMarkFactory();
    }

    public function testCreate()
    {
        $size = 65534;

        $binaryString = str_repeat('1', SecretTextConstant::INFO_MARK_LENGTH / 2 ) - 1;
        $binaryString .=  $binaryString;

        $infoMark = $this->infoMarkFactory->create($binaryString);

        $this->assertEquals($size, $infoMark->getSize()->getHeight());
        $this->assertEquals($size, $infoMark->getSize()->getHeight());
    }

    /**
     * @expectedException \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     */
    public function testFailCreate()
    {
        $binaryString = str_repeat('a', SecretTextConstant::INFO_MARK_LENGTH + 1);

        $this->infoMarkFactory->create($binaryString);
    }
}
