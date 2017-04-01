<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\File\NameGenerator;

use Picamator\SteganographyKit2\Kernel\File\NameGenerator\PrefixTime;
use Picamator\SteganographyKit2\Kernel\File\NameGenerator\SourceIdentical;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class AbstractGeneratorTest extends BaseTest
{
    /**
     * @var \Picamator\SteganographyKit2\Kernel\File\NameGenerator\AbstractGenerator | \PHPUnit_Framework_MockObject_MockObject
     */
    private $generatorMock;

    protected function setUp()
    {
        parent::setUp();

        $this->generatorMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\File\NameGenerator\AbstractGenerator')
            ->getMockForAbstractClass();
    }

    public function testGenerate()
    {
        $sourceName = 'test.jpg';

        $generatedName = 'new-name';
        $extension = 'jpg';

        // generator mock
        $this->generatorMock->expects($this->once())
            ->method('getFileName')
            ->willReturn($generatedName);

        $actual = $this->generatorMock->generate($sourceName, $extension);
        $this->assertEquals($generatedName . '.' . $extension, $actual);
    }
}
