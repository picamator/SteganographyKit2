<?php
namespace Picamator\SteganographyKit2\Tests\Integration\Kernel\Text;

use Picamator\SteganographyKit2\Kernel\Primitive\ByteFactory;
use Picamator\SteganographyKit2\Tests\Integration\Kernel\BaseTest;
use Picamator\SteganographyKit2\Kernel\Text\AsciiFactory;
use Picamator\SteganographyKit2\Kernel\Text\Iterator\IteratorFactory;
use Picamator\SteganographyKit2\Kernel\Text\LengthFactory;
use Picamator\SteganographyKit2\Kernel\Text\Text;
use Picamator\SteganographyKit2\Kernel\Util\ObjectManager;

class TextTest extends BaseTest
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var IteratorFactory
     */
    private $iteratorFactory;

    /**
     * @var LengthFactory
     */
    private $lengthFactory;

    protected function setUp()
    {
        parent::setUp();

        $this->objectManager = new ObjectManager();

        // itarator factory
        $byteFactory = new ByteFactory($this->objectManager);
        $asciiFactory = new AsciiFactory($this->objectManager, $byteFactory);

        $this->iteratorFactory = new IteratorFactory($this->objectManager, $asciiFactory);

        $this->lengthFactory = new LengthFactory($this->objectManager);
    }

    /**
     * @dataProvider providerSerialIterator
     *
     * @param string $path
     */
    public function testSerialIterator(string $path)
    {
        $expected = ["0", "1"];

        $path = $this->getPath($path);
        $data = file_get_contents($path);

        $text = new Text($this->iteratorFactory, $this->lengthFactory, $data);

        // length
        $lengthBits = $text->getLengthBits();
        $this->assertNotEmpty($lengthBits);

        // iteration
        $i = 0;
        foreach($text as $item) {
            $this->assertContains($item, $expected);
            $i++;
        }

        $this->assertEquals($lengthBits, $i);
    }

    public function providerSerialIterator()
    {
        return [
            ['secret' . DIRECTORY_SEPARATOR . 'ivan-kotliarevsky.txt']
        ];
    }
}
