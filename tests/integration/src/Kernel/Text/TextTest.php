<?php
namespace Picamator\SteganographyKit2\Tests\Integration\Kernel\Text;

use Picamator\SteganographyKit2\Kernel\Primitive\ByteFactory;
use Picamator\SteganographyKit2\Kernel\Text\Filter\BinaryToTextFilter;
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

    /**
     * @var BinaryToTextFilter
     */
    private $binaryToStringFilter;

    protected function setUp()
    {
        parent::setUp();

        $this->objectManager = new ObjectManager();

        // itarator factory
        $byteFactory = new ByteFactory($this->objectManager);
        $asciiFactory = new AsciiFactory($this->objectManager, $byteFactory);

        $this->iteratorFactory = new IteratorFactory($this->objectManager, $asciiFactory);

        $this->lengthFactory = new LengthFactory($this->objectManager);

        $this->binaryToStringFilter = new BinaryToTextFilter();
    }

    /**
     * @dataProvider providerSerialIterator
     *
     * @param string $data
     */
    public function testSerialIterator(string $data)
    {
        $expected = ["0", "1"];
        $text = new Text($this->iteratorFactory, $this->lengthFactory, $data);

        // length
        $lengthBits = $text->getLengthBits();
        $this->assertNotEmpty($lengthBits);

        // iteration
        $i = 0;
        $binaryText = '';
        foreach($text as $item) {
            $binaryText .= $item;

            $this->assertContains($item, $expected);
            $i++;
        }
        $this->assertEquals($lengthBits, $i);

        // filter
        $actualText = $this->binaryToStringFilter->filter($binaryText);
        $this->assertEquals($data, $actualText);
    }

    public function providerSerialIterator()
    {
        return [
            ['Hello Steganography!'],
            [$this->getFileContents('secret' . DIRECTORY_SEPARATOR . 'ivan-kotliarevsky.txt')],
        ];
    }
}
