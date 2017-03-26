<?php
namespace Picamator\SteganographyKit2\Tests\Integration\LsbText\SecretText;

use Picamator\SteganographyKit2\Kernel\Primitive\ByteFactory;
use Picamator\SteganographyKit2\Kernel\SecretText\EndMark;
use Picamator\SteganographyKit2\Kernel\Text\AsciiFactory;
use Picamator\SteganographyKit2\Kernel\Text\Iterator\IteratorFactory;
use Picamator\SteganographyKit2\Kernel\Text\LengthFactory;
use Picamator\SteganographyKit2\Kernel\Text\Text;
use Picamator\SteganographyKit2\Kernel\Util\ObjectManager;
use Picamator\SteganographyKit2\LsbText\SecretText\SecretText;
use Picamator\SteganographyKit2\Tests\Integration\LsbText\BaseTest;

class SecretTextTest extends BaseTest
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
     * @var EndMark
     */
    private $endMark;

    protected function setUp()
    {
        parent::setUp();

        // util
        $this->objectManager = new ObjectManager();

        // iterator factory
        $byteFactory = new ByteFactory( $this->objectManager);
        $asciiFactory = new AsciiFactory($this->objectManager, $byteFactory);

        $this->iteratorFactory = new IteratorFactory($this->objectManager, $asciiFactory);

        $this->lengthFactory = new LengthFactory($this->objectManager);

        $this->endMark = new EndMark();
    }

    /**
     * @dataProvider providerIterator
     *
     * @param string $data
     */
    public function testIterator(string $data)
    {
        $expected = ['0', '1'];

        $text = new Text($this->iteratorFactory, $this->lengthFactory, $data);
        $secretText = new SecretText($text, $this->endMark);

        $i = 0;
        foreach ($secretText as $item) {
           $this->assertContains($item, $expected);
           $i++;
        }

        $this->assertEquals($i, $secretText->getCountBit());
    }

    public function providerIterator()
    {
        return [
            ['Hello Steganography!']
        ];
    }
}
